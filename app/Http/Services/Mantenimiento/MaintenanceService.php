<?php

namespace app\Http\Services\Mantenimiento;

use App\Http\Services\Tatuco\ReportService;
use App\Http\Services\Tatuco\TatucoService;
use App\Http\Services\Mantenimiento\DetailMaintenanceService;
use App\Models\Gasolinera\Vehicle;
use App\Models\Mantenimiento\EntrieMaintenance;
use App\Models\Mantenimiento\Maintenance;
use App\Models\Mantenimiento\OutputMaintenance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MaintenanceService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'maintenance';
        $this->model = new Maintenance();
        $this->namePlural = 'maintenances';
    }

    /**
     * @return json con los registros
     */
    public function index(Request $request)
    {
        //consulto los permisos
        if (($this->checkPermission('index.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso index.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para listar registros de este modulo');
        }

        $hoy = Carbon::now(); //instancio fecha actual


        $user = $this->currentUSer();
        $select = Maintenance::from('maintenances as m')
            ->select("m.mai_id","v.veh_pla", "v.veh_id", "m.created_at","m.mai_fec_ex",
                "em.ema_des", "om.oma_des", "s.sta_des")
            ->leftJoin("detail_maintenances as dm", "dm.mai_id", "m.mai_id")
            ->leftJoin("vehicles as v", "v.veh_pla", "m.veh_pla")
            ->leftJoin("entries_maintenances as em", "em.dma_id", "dm.dma_id")
            ->leftJoin("outputs_maintenances as om", "om.dma_id", "dm.dma_id")
            ->leftJoin("status as s","s.sta_id","m.sta_id")
            ->orderBy('m.created_at', 'desc');

        $namePlural='Operacioness';
        //setea las nombres con las columnas en la bd
        $columns = [
            'Op' =>'mai_id',
            'Id' =>'veh_id',
            'Placa' => 'veh_pla',
            'Estado del Vehiculo' => 'sta_des',
            'Respuesta Gps Ent.' => 'ema_des',
            'Fecha de Entrada' => 'created_at',
            'Respuesta Gps Sal.' => 'oma_des',
            'Fecha de Salida' => 'mai_fec_ex',
        ];
        $title='Reporte de Operaciones';
        $model= new Maintenance();
        $status = 'm.mai_act';
        $acc = 'm.acc_id';
        $created = 'm.created_at';

        return (new ReportService())->report($request, $model, null, null, $status, $acc,
            $created, $namePlural, $columns, $select, $title);

        //return response()->json($query, 200);
    }

    /**
     * @param Request $request
     * @return mensaje de respuesta de guardado
     */
    public function store(Request $request)
    {
        //consulto los permisos
        if (($this->checkPermission('store.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso store.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para crear entradas al taller');
        }
        $user = $this->currentUSer();
        $entrie = Maintenance::from('maintenances as m')
            ->join('detail_maintenances as dm', 'dm.mai_id','m.mai_id')
            ->where('m.veh_pla',$request->veh_pla)
            ->where('m.sta_id',7)
            ->where('m.mai_act',true)
            ->where('m.acc_id',$user->acc_id)
            ->first();

        if($entrie){//si el vehiculo ya esta dentro, llamo al metodo de procesar la salida
            return $this->outputMaintenance($request->veh_pla, $entrie->dma_id, $request->use_nic, $request->acc_id);
        }
        try{


            DB::beginTransaction();

            //guardo el expensefuel
            $maintenance = new Maintenance();
            $maintenance->use_nic_en = $request->use_nic;
            $maintenance->veh_pla = $request->veh_pla;
            $maintenance->sta_id = 7;
            $maintenance->acc_id = $request->acc_id;
            $maintenance->save();

            //agarro el id
            $id = $maintenance->mai_id;

            //envio para guardar el detalle
            $id_detail = (new DetailMaintenanceService())->storeDetail($id, $request->use_nic, $request->acc_id);

            //envio para guardar el registro de la entrada
            $this->entrieMaintenance($request->veh_pla, $id_detail, $request->use_nic, $request->acc_id);
            DB::commit();

            return  response()->json(["message" => "Se registro la entrada del vehiculo al taller"], 200)
                ->setStatusCode(200, 'Se registro la entrada del vehiculo al taller');

        }catch(\Exception $e){
            //si no se inserta correctamente se hace rollback
            DB::rollback();
            return  response()->json(["message" => "Ocurrio un error al intentar registrar"], 500)
                ->setStatusCode(500, 'Ocurrio un error al intentar registrar');
        }
    }

    /**
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @param Request $request
     * @return _update de tatucoService
     */
    public function update($g_namePrimaryKey, $x_pk, $g_status, Request $request)
    {
        return $this->_update($g_namePrimaryKey, $x_pk, $g_status, $request);
    }

    /**
     * @param $x_veh_pla = placa del vehiculo
     * @param $x_id = id del detalle de la operacion
     * @param $x_acc = id del account
     */
    public function entrieMaintenance($x_veh_pla, $x_id, $x_user, $x_acc)
    {
        $respGps = $this->consultGps($x_veh_pla);//consulto el gps

        $entries = new EntrieMaintenance();
        $entries->dma_id = $x_id;
        $entries->ema_des = $respGps;
        $entries->use_nic = $x_user;
        $entries->acc_id = $x_acc;
        $entries->save();
    }

    /**
     * @param $x_veh_pla = placa del vehiculo
     * @param $x_id = id del detalle de la operacion
     * @param $x_acc = id del account
     * @return mensaje de salida de taller, o un error
     */
    public function outputMaintenance($x_veh_pla, $x_id, $x_user, $x_acc)
    {
        $respGps = $this->consultGps($x_veh_pla);//consulto el gps
        $user = $this->currentUSer();
        try{
            DB::beginTransaction();
            //guardo la salida del vehiculo
            $entries = new OutputMaintenance();
            $entries->dma_id = $x_id;
            $entries->oma_des = $respGps;
            $entries->use_nic = $x_user;
            $entries->acc_id = $x_acc;
            $entries->save();

            $now = Carbon::now()->format('Y/m/d h:i:s');
            //actualizo el status a fuera
            $detail = Maintenance::where('veh_pla',$x_veh_pla)
                ->where('sta_id',7)
                ->where('mai_act',true)
                ->where('acc_id',$user->acc_id)
                ->first(['*']);
            $detail->mai_fec_ex = $now;
            $detail->use_nic_ex = $x_user;
            $detail->sta_id = 8;
            $detail->update();

            DB::commit();//guardo

            return  response()->json(["message" => "Se registro la salida del vehiculo del taller"], 200)
                ->setStatusCode(200, 'Se registro la salida del vehiculo del taller');

        }catch (\Exception $e){
            //si no se inserta correctamente se hace rollback
            DB::rollback();
            return  response()->json(["message" => "Ocurrio un error al intentar registrar"], 500)
                ->setStatusCode(500, 'Ocurrio un error al intentar registrar');
        }

    }

    /**
     * @param $x_veh_pla = placa del vehiculo
     * @param null $flag bandera para saber si estoy consultando el gps a traves del front, o si viene del la insercion
     * de entrada o salida, si viene null es porque viene del metodo entrieMaintenance o outputmaintenance
     * @return boleeano o la respuesta del status de gps dependiendo de quien consulte
     */
    public function consultGps($x_veh_pla, $x_flag = null)
    {
        $user = $this->currentUSer();//consulto user logueado
        //consulto el vehiculo por la placa para obtener el id del vehiculo
        $vehicle = Vehicle::where('veh_pla',$x_veh_pla)
            ->where('veh_act',true)
            ->where('acc_id',$user->acc_id)
            ->first();

        if($vehicle){
            $idVehicle = $vehicle->veh_id;//extraigo el id de vehiculo
            //armo el endpoint concatenando el id del vehiculo
            try{
                $endpoint = "https://zippygps.zippyttech.com/events/data.json?account=aguaseo&password=123456&d=$idVehicle&l=1";
                $resp = file_get_contents($endpoint);//ejecuto la consulta a gps
                $resp = json_decode($resp);//convierto en array la respuesta
                if(isset($resp->Error)){//si gps no consigue el vehiculo
                    if ($x_flag != null){//si flag viene es porque consulta el front
                        return 2; // retorno 2 porque no se encuentra el dispositivo
                    }
                    return "No se encontro el gps del vehiculo - Resp: $resp->Error"; //retorno el codigo de error
                }else{
                    $day = $resp->DeviceList[0]->EventData[0]->Timestamp_date;//extraigo la fecha
                    $time = $resp->DeviceList[0]->EventData[0]->Timestamp_time;//extraigo la hora
                    $day_hour = "$day $time";//concateno las dos
                    $now = Carbon::now()->SubHour(8)->format('Y/m/d h:i:s');//resto 8 horas a la actual para comparar
                    //consulto si la hora de la respuesta es menor a 8 horas

                    if($day_hour < $now){
                        if ($x_flag != null){//si flag viene es porque consulta el front
                            return 0;//retorno 0 porque el gps no reporta
                        }
                        $statusH = $resp->DeviceList[0]->EventData[0]->StatusCode_hex;//extraigo el status hexadecimal
                        $status = $resp->DeviceList[0]->EventData[0]->StatusCode_desc;//extraigo el status
                        return  "El gps no reporto las ultimas 8 horas - UltimaResp: $status ($statusH)"; //retorno el status
                    }else{
                        if ($x_flag != null){//si flag viene es porque consulta el front
                            return 1; //retorno 1 porque el gps reporta
                        }
                        $statusH = $resp->DeviceList[0]->EventData[0]->StatusCode_hex;//extraigo el status hexadecimal
                        $status = $resp->DeviceList[0]->EventData[0]->StatusCode_desc;//extraigo el status
                        return  "El gps esta reportando - Resp: $status ($statusH)"; //retorno el status
                    }
                }
            }catch (\Exception $e){//si surge una excepcion
                if ($x_flag != null){//si flag viene es porque consulta el front
                    return 0;//retorno 0 porque el gps no reporta
                }
                return "No se encontro el gps del vehiculo"; //retorno el codigo de error
            }
        }

    }

    public function statusMaintenance($x_veh_pla)
    {
        $user = $this->currentUSer();
        $entrie = Maintenance::from('maintenances as m')
            ->join('detail_maintenances as dm', 'dm.mai_id','m.mai_id')
            ->where('m.veh_pla',$x_veh_pla)
            ->where('m.sta_id',7)
            ->where('m.mai_act',true)
            ->where('m.acc_id',$user->acc_id)
            ->first();

        if($entrie){//si el vehiculo ya esta dentro return 0
           return 0;
        }
        return 1;
    }
}
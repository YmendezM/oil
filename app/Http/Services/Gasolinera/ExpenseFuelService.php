<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\ReportService;
use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\DetailExpenseFuel;
use App\Models\Gasolinera\Driver;
use App\Models\Gasolinera\ExpenseFuel;
use App\Models\Gasolinera\Fuel;
use App\Http\Services\Gasolinera\FuelService;
use App\Http\Services\Gasolinera\NotificationService;
use App\Http\Services\Gasolinera\AuditService;
use App\Http\Services\Gasolinera\DriverService;
use App\Models\Gasolinera\Notification;
use App\Models\Gasolinera\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ExpenseFuelService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'expense_fuel';
        $this->model = new ExpenseFuel();
        $this->namePlural = 'expenses_fuels';
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
        $id = $request->get('id');  //saco del request los datos que necesito


        //condicionales de filtrado de las operaciones
        if($id ==1){//semanal
            $daylast = strtotime('next sunday');//obtengo el proximo domingo
            $toDate = date('Y-m-d', $daylast);//transformo la fecha obtenida

            //resto la fecha del ultimo domingo para sacar el dia lunes
            $fromDate = strtotime ( '-6 day' , strtotime ( $toDate ) ) ;
            $fromDate = date ( 'Y-m-d' , $fromDate );

        }else if($id==2){//mensual
            //saco el primer dia
            $month = date('m');
            $year = date('Y');
            $fromDate = date('Y-m-d', mktime(0,0,0, $month, 1, $year));//fecha fin

            //saco el ultimo dia
            $month = date('m');
            $year = date('Y');
            $day = date("d", mktime(0,0,0, $month+1, 0, $year));
            $toDate = date('Y-m-d', mktime(0,0,0, $month, $day, $year));
        }else{//rango
            $fromDate = $request->get('from_date');//fecha de inicio
            $toDate = $request->get('to_date');//fecha fin
        }

        $user = $this->currentUSer();
        $select = ExpenseFuel::from('expenses_fuels as ef')
            ->select("ef.exp_id","v.veh_pla", "v.veh_id", "d.dri_nam as name",
                "f.fue_oct",DB::raw("cast(format_numbers(def.dex_qua) as numeric) as dex_qua"),
                'def.dex_hor', "ef.use_nic","ef.created_at")
            ->leftJoin("detail_expenses_fuels as def", "def.exp_id", "ef.exp_id")
            ->leftJoin("assignments as a", "a.ass_id", "ef.ass_id")
            ->leftJoin("vehicles as v", "v.veh_pla", "a.veh_pla")
            ->leftJoin("drivers as d", "d.dri_dni", "a.dri_dni")
            ->leftJoin("fuels as f", "f.fue_id", "def.fue_id")
            ->orderBy('ef.created_at', 'desc');

        $namePlural='Operaciones';
        //setea las nombres con las columnas en la bd
        $columns = [
            'Op' =>'exp_id',
            'Id' =>'veh_id',
            'Placa' => 'veh_pla',
            'Conductor' => 'name',
            'Combustible' => 'fue_oct',
            'Cantidad' => 'dex_qua',
            'Horometro' => 'dex_hor',
            'Usuario' => 'use_nic',
            'Fecha/Hora' => 'created_at',
        ];
        $title='Reporte de Operaciones';
        $model= new ExpenseFuel();
        $status = 'ef.exp_act';
        $acc = 'ef.acc_id';
        $created = 'ef.created_at';

        return (new ReportService())->report($request, $model, $fromDate, $toDate, $status, $acc,
            $created, $namePlural, $columns, $select, $title);

        //return response()->json($query, 200);
    }

    /**
     * @param Request $request
     * @return json con la respuesta del guardado
     */
    public function store(Request $request)
    {
        $quantity = (new FuelService())->convertFuel($request->veh_com, $request->medida); //convierto la cantidad

        //consulto los permisos
        if (($this->checkPermission('store.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso store.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para crear operaciones');
        }

        try{
            if(!$request->placa){
                return  response()->json(["message" => "El Vehiculo no existe en la base de datos"], 500)
                    ->setStatusCode(500, 'El Vehiculo no existe en la base de datos');
            }
            $idFuel = $request->tipo_comb2;
            $fuel = Fuel::where("fue_id","=",$idFuel)->first();//selecciono el combustible para consultar la cantidad
            /*if($quantity > $fuel->fue_qua){//si la cantidad dispensada es mayor a la en stock envie mensaje
                return (new response())->setStatusCode(500, 'La cantidad dispensada ('.$request->veh_com. ') excede la cantidad de combustible en stock');
            }*/

            //creo la asignacion
            $resp = (new DriverService())->assignment($request->dni, $request->placa);//recibo la respuesta de la funcion
            if($resp==false){
                return  response()->json(["message" => "Error al intentar crear la asignacion"], 500)
                    ->setStatusCode(500, 'Error al intentar crear la asignacion');
            }else{
              $ass_id = $resp;
            }

            DB::beginTransaction();

            //guardo el expensefuel
            $operation = new ExpenseFuel();

            if($request->created_at){//si viene fecha distinta tome la fecha, sino tome la del servidor
                //compruebo si la fecha recibida sea menor o igual a la actual
                //no se pueden registrar operaciones con fecha mayor a la actual
                $now = Carbon::now()->format('Y-m-d h:i:s');
                if($request->created_at > $now){
                    return  response()->json(["message" => "No puede crear una operacion con una fecha superior a la actual"], 500)
                        ->setStatusCode(500, 'No puede crear una operacion con una fecha superior a la actual');
                }

                $operation->created_at = $request->created_at;
            }
            $operation->use_nic = $request->use_nic;
            $operation->ass_id = $ass_id;
            $operation->acc_id = $request->acc_id;
            $operation->save();

            //agarro el id
            $id = $operation->exp_id;

            //guardo el detail_expense_fuel
            $detail = new DetailExpenseFuel();
            $detail->dex_qua = $quantity;
            $detail->dex_hor = $request->dex_hor;
            $detail->exp_id = $id;
            $detail->tfu_id = $request->tipo_comb;
            $detail->fue_id = $request->tipo_comb;
            $detail->acc_id = $request->acc_id;
            $detail->save();

            /*//busco la asignacion para traer la placa del vehiculo
            $assignment = Assignment::where("ass_id","=",$request->ass_id)->first();

            //busco el vehiculo atraves de la placa para ver el consumo diario maximo*/
            $vehicle = Vehicle::where("veh_pla","=",$request->placa)->first();
            (new NotificationService())->notificationVehicle($request->veh_com, $request->acc_id, $request->placa, $quantity);

            //busco el conductor si existe atraves del dni para ver el consumo diario maximo
            if($request->dni){
                $driver = Driver::where("dri_dni","=",$request->dni)->first();
                (new NotificationService())->notificationDriver($request->veh_com, $request->acc_id, $request->dni, $quantity);
            }


            DB::commit();

            return  response()->json(["message" => "Operacion registrada exitosamente"], 200)
                ->setStatusCode(200, 'Operacion registrada exitosamente');

        }catch(\Exception $e){
            //si no se inserta correctamente se hace rollback
            DB::rollback();
            return  response()->json(["message" => "Ocurrio un error al registrar la operacion"], 500)
                ->setStatusCode(500, 'Ocurrio un error al registrar la operacion');
        }
    }

    /**
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @param Request $request
     * @return _respuesta correcta de la modificacion
     */
    public function update($g_namePrimaryKey, $x_pk, $g_status, Request $request)
    {
        //consulto el usuario logueado
       $user = $this->currentUSer();

       //consulto la data vieja
        $query= ExpenseFuel::from('expenses_fuels as ef')
            ->select("ef.exp_id", "ef.use_nic","v.veh_pla", "v.veh_id","d.dri_nam as name","ef.created_at",
                DB::raw("cast(format_numbers(def.dex_qua) as numeric) as dex_qua"),'def.dex_hor',"f.fue_oct")
            ->leftJoin("detail_expenses_fuels as def", "def.exp_id", "ef.exp_id")
            ->leftJoin("assignments as a", "a.ass_id", "ef.ass_id")
            ->leftJoin("vehicles as v", "v.veh_pla", "a.veh_pla")
            ->leftJoin("drivers as d", "d.dri_dni", "a.dri_dni")
            ->leftJoin("fuels as f", "f.fue_id", "def.fue_id")
            ->where("ef.exp_act", true)
            ->where("ef.acc_id", $user->acc_id)
            ->where("ef.exp_id", $x_pk)
            ->orderBy('ef.exp_id')
            ->get();

        //envio la data a auditoria
        (new AuditService())->insertAudit($request, $query, $x_pk, 'modifico', 'dispensar combustible');


        //envio a tatuco service
       return $this->_update($g_namePrimaryKey, $x_pk, $g_status, $request);
    }

    /**
     * metodo que elimina logicamente el detalle de la operacion, llama al padre para eliminar la operacion
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_fk = valor de la llave primaria por la que va a consultar
     * @param $g_status = nombre del campo status
     * @return _destroy de tatucoService
     */
    public function destroy($g_namePrimaryKey, $x_pk, $g_status)
    {
        //consulto los permisos
        if (($this->checkPermission('delete.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso delete.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para eliminar registros de este modulo');
        }

        //elimino el detalle de la operacion
        $detail = DetailExpenseFuel::where('exp_id',$x_pk)->first(['*']);
        $detail->dex_act = false;
        $detail->update();

        $quantity = $detail->dex_qua;//saco la cantidad dispensada
        $fue_id = $detail->fue_id;//saco el id del combustible

        //retorno la cantidad dispensada a la tabla combustible
        $fuel = Fuel::where('fue_id',$fue_id)->first(['*']);
        $fuel->fue_qua = ($fuel->fue_qua + $quantity);//sumo la cantidad
        $fuel->update();

        //lamo al padre para eliminar la operacion
        return $this->_destroy($g_namePrimaryKey, $x_pk, $g_status);
    }

    /**
     * metodo que buscar
     * @return \Illuminate\Http\JsonResponse
     */
    //public function findForPlate()
    //{

        //consulto los datos del que esta loggueado
        /*$user = \JWTAuth::parseToken()->authenticate();
        //assigno a account el dato del campo
        $acc_id = $user->acc_id;
        $resourceOptions = $this->parseResourceOptions();
        //selecciono si hay asignado un vehiculos
        $select = DB::table('assignments as a')
            ->select('a.veh_pla as value','v.veh_pla as text')
            ->join('drivers as d', 'a.dri_dni','d.dri_dni')
            ->join('vehicles as v','a.veh_pla','v.veh_pla')
            ->where('a.ass_act',true)
            ->where('v.acc_id',$acc_id)
            ->get();*/
        //$parsedData = $this->parseData($select, $resourceOptions/*, $this->namePlural*/);

        //return response()->json($parsedData, 200);

    //}

    //devolver los datos de usuario y demas por placa
    //public function assignmentsForPlate($x_placa)
    //{
        //consulto los datos del que esta loggueado
       /* $user = \JWTAuth::parseToken()->authenticate();
        //assigno a account el dato del campo
        $acc_id = $user->acc_id;
        $resourceOptions = $this->parseResourceOptions();
        //selecciono si hay asignado un vehiculos
        $select = DB::table('assignments as a')
            ->select('a.ass_id','d.dri_dni','d.dri_nam','d.dri_lna', 'v.veh_pla','bv.bra_des','mv.mod_des')
            ->rightJoin('vehicles as v','a.veh_pla','v.veh_pla')
            ->rightJoin('drivers as d', 'a.dri_dni','d.dri_dni')
            ->rightJoin('brands_vehicles as bv', 'bv.bra_id','v.bra_id')
            ->rightJoin('models_vehicles as mv', 'mv.mod_id','v.mod_id')
            ->where('d.dri_act',true)
            ->where('d.acc_id',$acc_id)
            ->where('a.veh_pla',$x_placa)
            ->get();*/

       // $parsedData = $this->parseData($select, $resourceOptions/*, $this->namePlural*/);

        //return response()->json($parsedData, 200);
    //}


    /**
     * metodo que consulta todos los vehicles para que el front haga una precarga
     * @return json con los datos de todos los vehicles
     */
    public function findVehicle()
    {
        //consulto los datos del que esta loggueado
        $user = $this->currentUSer();
        //selecciono si hay asignado un vehiculos
        $select = DB::table('vehicles as v')
            ->select('v.veh_pla as value','v.veh_id as text')
            ->where('v.veh_act',true)
            ->where('v.acc_id',$user->acc_id)
            ->get();

        return response()->json($select, 200);
    }


    /**
     * metodo que consulta todos los drivers para que el front haga una precarga
     * @return json con los datos de todos los drivers
     */
    public function findDriver()
    {
        //consulto los datos del que esta loggueado
        $user = $this->currentUSer();
        //selecciono si hay asignado un vehiculos
        $select = DB::table('drivers as d')
            ->select('d.dri_dni as value','d.dri_nam as text')
            ->where('d.dri_act',true)
            ->where('d.acc_id',$user->acc_id)
            ->get();

        return response()->json($select, 200);
    }


    /**
     * @param $x_plate = placa del vehicle
     * @return json con los datos del vehicle asignado a la operacion
     */
    public function assignmentsVehicle($x_plate)
    {
        //consulto los datos del que esta loggueado
        $user = $this->currentUSer();
        //selecciono si hay asignado un vehiculos
        $select = DB::table('vehicles as v')
            ->select('v.veh_pla', 'v.veh_id','bv.bra_des','mv.mod_des')
            ->leftJoin('brands_vehicles as bv', 'bv.bra_id','v.bra_id')
            ->leftJoin('models_vehicles as mv', 'mv.mod_id','v.mod_id')
            ->where('v.veh_act',true)
            ->where('v.acc_id',$user->acc_id)
            ->where('v.veh_pla',$x_plate)
            ->get();

        return response()->json($select, 200);
    }

    /**
     * @param $x_dni = dni del driver
     * @return json con los datos del driver asignado a la operacion
     */
    public function assignmentsDriver($x_dni)
    {
        //consulto los datos del que esta loggueado
        $user = $this->currentUSer();
        //selecciono si hay asignado un vehiculos
        $select = DB::table('drivers as d')
            ->select('d.dri_dni','d.dri_nam','d.dri_lna')
            ->where('d.dri_act',true)
            ->where('d.acc_id',$user->acc_id)
            ->where('d.dri_dni',$x_dni)
            ->get();

        return response()->json($select, 200);
    }

    /**
     * metodo que consulta el id de la nueva operacion
     * @return id de la operacion
     */
    public function returnIdOperation()
    {
        $seq = DB::select('select last_value  from expenses_fuels_exp_id_seq');
        return $seq[0]->last_value+1;
    }
}

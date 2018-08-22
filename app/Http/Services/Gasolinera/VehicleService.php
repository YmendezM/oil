<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\Assignment;
use App\Models\Gasolinera\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'vehicle';
        $this->model = new Vehicle();
        $this->namePlural = 'vehicles';
    }

    /**
     * @return json con el listado de registros
     */
    public function index(Request $request)
    {
        //consulto los permisos
        if (($this->checkPermission('index.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso index.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para listar registros de este modulo');
        }
        $user = $this->currentUSer();
        $query = Vehicle::from('vehicles as v')
            ->select('veh_id','v.veh_pla',DB::raw("cast(format_numbers(v.veh_com) as numeric) as veh_com"),'t.tve_des','t.tve_id','m.mod_des','m.mod_id',
                'f.fle_des','f.fle_id','b.bra_des','b.bra_id','s.sta_des','s.sta_id')
            ->leftJoin('type_vehicles as t','t.tve_id','v.tve_id')
            ->leftJoin('models_vehicles as m','m.mod_id','v.mod_id')
            ->leftJoin('fleets as f','f.fle_id','v.fle_id')
            ->leftJoin('brands_vehicles as b','b.bra_id','v.bra_id')
            ->leftJoin('status as s','s.sta_id','v.sta_id')
            ->where('v.veh_act',true)
            ->where('v.acc_id',$user->acc_id)
            ->get();

        return response()->json($query, 200);
    }

    /**
     * @param Request $request
     * @return _store de tatucoService
     */
    public function store(Request $request)
    {
        $plate = $request->veh_pla;
        $veh_pla = Vehicle::where("veh_pla","=",$plate)
            ->first();
        if($veh_pla){
            return (new response())->setStatusCode(500, 'La placa '.$plate. ' ya existe en la base de datos');
        }
        return $this->_store($request);
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
        if($request->json(['mod_id'])==0){
            $pass =null;
            $request->merge(['mod_id' => $pass]);
        }
        //envio a tatuco service
        return $this->_update($g_namePrimaryKey, $x_pk, $g_status, $request);
    }

    /**
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
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
        //consulto el account logueado
        $user = $this->currentUSer();
        $select = Assignment::where("veh_pla","=",$x_pk)
            ->where("ass_act","=",true)
            ->where("acc_id","=",$user->acc_id)
            ->first();
        if($select){
            $id = $select->ass_id;
            //si esta asignado modificio la asignacion a false
            $update = Assignment::find($id);
            $update->ass_act = false;
            $update->save();
        }
        return $this->_destroy($g_namePrimaryKey, $x_pk, $g_status);
    }

    /**
     * metodo que consulta los vehiculos para el comboselect del front
     * @return json con los vehiculos
     */
    public function selectVehicle(){
        $user = $this->currentUSer();
        $query = Vehicle::select('veh_pla as value', 'veh_pla as text')
            ->where('acc_id',$user->acc_id)
            ->where('veh_act', true)
            ->where('sta_id', 5)
            ->get();

        return response()->json($query, 200);

    }

}
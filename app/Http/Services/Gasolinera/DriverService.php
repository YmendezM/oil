<?php

namespace app\Http\Services\Gasolinera;

use App\Models\Gasolinera\Assignment;
use App\Models\Gasolinera\Driver;
use App\Http\Services\Tatuco\TatucoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DriverService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'driver';
        $this->model = new Driver();
        $this->namePlural = 'drivers';
    }

    /**
     * @return json con los registros consultados
     */
    public function index(Request $request)
    {
        //consulto los permisos
        if (($this->checkPermission('index.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso index.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para listar registros de este modulo');
        }
        //consulto usuario logueado
        $user = $this->currentUSer();
        $query = Driver::from('assignments as a')
            ->select('d.dri_dni',DB::raw("cast(format_numbers(d.dri_com) as numeric) as dri_com"),'d.dri_nam','d.dri_lna','d.dri_lic','d.dri_pho','d.dri_mai','d.sta_id','a.veh_pla','s.sta_des')
            ->rightJoin('vehicles as v','v.veh_pla','a.veh_pla')
            ->rightJoin('drivers as d','d.dri_dni','a.dri_dni')
            ->rightJoin('status as s','s.sta_id','d.sta_id')
            ->where('d.dri_act',true)
            ->where('a.ass_act',true)
            ->where('d.acc_id',$user->acc_id)
            ->get();


        return response()->json($query, 200);
    }

    /**
     * @param Request $request
     * @return json con la respuesta del guardado
     */
    public function store(Request $request)
    {
        //consulto los permisos
        if (($this->checkPermission('store.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso store.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para crear registros de este modulo');
        }
        if (count($this->data) == 0) {
            $this->data = $request->all();
        }
        //seleccionar dni para ver si ya existe
        $dri_dni=$request->dri_dni;
        $dri_lic=$request->dri_lic;
        //valido si datos del usuario esta registrado (dni, username)
        $dni = Driver::where("dri_dni","=",$dri_dni)
            ->first();
        //valido si datos del usuario esta registrado (dni, username)
        $lic = Driver::where("dri_lic","=",$dri_lic)
            ->where("dri_lic","<>",null)
            ->first();
        if($dni) {
            return  response()->json(["message" => "El DNI $dri_dni ya existe en la base de datos"], 500)
                ->setStatusCode(500, 'El DNI ' . $dri_dni . ' ya existe en la base de datos');
        }elseif($lic) {
            return  response()->json(["message" => "La licencia $dri_lic ya existe en la base de datos"], 500)
                ->setStatusCode(500, 'La licencia ' . $dri_lic . ' ya existe en la base de datos');
        }else{
            if($this->object = Driver::create($this->data)){
                if($request->json(['veh_pla'])){
                    $plate=$request->json(['veh_pla']);
                    $resp = $this->assignment($dri_dni, $plate);//recibo la respuesta de la funcion
                    if($resp==false){
                        DB::delete("delete from drivers where dri_dni = '$dni' ");
                        return response()->json(['status'=>false,
                            'message'=>$this->name. ' Ocurrio un error al guardar',
                            $this->name=>$this->object],
                            500);
                    }else{
                        return  response()->json(["message" => "Registro guardado con exito"], 200)
                            ->setStatusCode(200, 'Registro guardado con exito');
                    }
                }
                if($this->object){
                    return  response()->json(["message" => "Registro guardado con exito"], 200)
                        ->setStatusCode(200, 'Registro guardado con exito');
                }
            }
        }
    }

    /**
     * @param $x_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @param Request $request
     * @return json con la respuesta de la actualizacion
     */
    public function update($x_namePrimaryKey, $x_pk, $g_status, Request $request)
    {
        //consulto los permisos
        if (($this->checkPermission('update.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso update.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para modificar registros de este modulo');
        }
        $user = $this->currentUSer();
        $nic = $user->use_nic;
        //si se va a modificar el rol del usuario
        $plate = $request->veh_pla;
        if ($plate != null){
            $sel = Assignment::where("veh_pla","=",$plate)
                ->where("dri_dni","=",$x_pk)
                ->where("ass_act","=",true)
                ->where("acc_id","=",$user->acc_id)
                ->first();
            if(!$sel){
                $this->assignment($x_pk,$plate);
            }
        }
        //envio a tatuco service
       return $this->_update($x_namePrimaryKey, $x_pk, $g_status, $request);
    }

    /**
     * @param $x_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @return _destroy de tatucoService
     */
    public function destroy($x_namePrimaryKey, $x_pk, $g_status)
    {
        //consulto los permisos
        if (($this->checkPermission('delete.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso delete.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para eliminar registros de este modulo');
        }
        //consulto el account logueado
        $user = $this->currentUSer();
        $select = Assignment::where("dri_dni","=",$x_pk)
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
        //llama a tatucoService
        return $this->_destroy($x_namePrimaryKey, $x_pk, $g_status);
    }

    /**
     * metodo que asigna un vehiculo a un conductor
     * @param $x_dni = dni del driver
     * @param $x_pla = plate del vehicle
     * @return el id de la asignacion o false
     */
    public function assignment($x_dni, $x_pla)
    {
        $user = $this->currentUSer();
        $acc_id = $user->acc_id;
        $nic = $user->use_nic;
        //selecciono si hay asignado un vehiculos
        $select = Assignment::where("veh_pla","=",$x_pla)
                    ->where("ass_act","=",true)
                    ->where("acc_id","=",$acc_id)
                    ->first();
        if($select){
            $id = $select->ass_id;
            //si esta asignado modificio la asignacion a false
            $update = Assignment::find($id);
            $update->ass_act = false;
            $update->save();
        }
        //no pregunten porque hice la cochinada de hacer la validacion en dos consultas
        //separadas
        //NO QUIZO FUNCIONAR EN UN SOLO SELECT, no me pregunten porque
        $select1 = Assignment::where("dri_dni","=",$x_dni)
            ->where("ass_act","=",true)
            ->where("acc_id","=",$acc_id)
            ->first();
        if($select1){
            $id = $select1->ass_id;
            //si esta asignado modificio la asignacion a false
            $update = Assignment::find($id);
            $update->ass_act = false;
            $update->save();
        }
        $data = [
            "use_nic" => $nic,
            "dri_dni" => $x_dni,
            "veh_pla" => $x_pla,
            "acc_id" => $acc_id
        ];
        //inserto el nuevo registro
        $query = Assignment::create($data);
        if($query){
            return $query->ass_id;
        }
        return false;
    }




}
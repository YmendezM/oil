<?php

namespace App\Http\Services\Tatuco;

use App\Models\Gasolinera\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;

class TatucoService extends LaravelController
{
    use EloquentBuilderTrait;
    public $model;
    public $object;
    public $name;
    public $namePlural;
    public $paginate = false;
    public $limit = null;
    public $data = [];
    public $request;
    public $dato;

    /** token de sysadmin eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvbG9naW4iLCJpYXQiOjE1MTg0NzM5MjYsImV4cCI6MTUxODQ3NzUyNiwibmJmIjoxNTE4NDczOTI2LCJqdGkiOiIwQ2RBZ1JPS3N6ZFR1ZU1DIn0.4X9UtMLM5EwrLG_aSZ_3QEZ4oK0IZgbnMwoTpQUmmd0
     * @return \Illuminate\Http\JsonResponse
     * consultar todos los registros de un modelo
     * uso de parseresource y applyresource para el uso de los parametros
     * incude[] limits sorts etc ...
     * leer paquetes
     */
    public function __construct()
    {

    }

    /**
     * metodo de retorna todos los registros de la tabla consultada
     * @param $g_status=nombre de la columna del status
     * @param $request_status= los datos de la consulta
     * @return  json con el listado de los usuarios que tengan el status true
     */
    public function _index(Request $request, $g_status){
        //consulto los permisos
        if (($this->checkPermission('index.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso index.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para listar registros de este modulo');
        }
        $user = $this->currentUSer(); //consulto los datos del que esta loggueado
        $query = $this->model::query()->where($g_status,true)//ejecuto el query
            ->where('acc_id',$user->acc_id)
            ->get();

        return response()->json($query, 200);
    }

    /**
     * metodo que retorna el registro que coincide con el filtrado de busqueda
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_fk = valor de la llave primaria por la que va a consultar
     * @param $g_status = nombre del campo status
     * @return json con el registro que coincida con el valor de la llave primaria y el status sea true
     */
    public function _show($g_namePrimaryKey, $x_fk, $g_status)
    {
        try{
            //consulto los permisos
            if (($this->checkPermission('show.'.$this->name)) == false ) {
                return  response()->json(["message" => "no tienes permiso show.$this->name"], 403)
                    ->setStatusCode(403, 'no tienes permiso para ver registros de este modulo');
            }
            $this->data = $this->findTatuco($g_namePrimaryKey, $x_fk, $g_status); //consulto el registro
            if(!$this->data) //si no consigue nada delvuelve 404
            {
                return response()->json(['message'=>$this->name. ' no existe'], 404);
            }
            return response()->json([
                'status'=>true,
                'message'=> $this->name. ' Encontrado',
                $this->name => $this->data,
            ], 200);

            //si ocurre alguna exception la devuelve
        }catch (\Exception $e){
            Log::critical("Error, archivo del error: {$e->getFile()}, linea del error: {$e->getLine()}, el peo: {$e->getMessage()}, codigo del peo: {$e->getCode()}");
            return response()->json([
                "message"=>"Error de servidor",
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode()
            ], 500);
        }
    }

    /**
     * metodo que guarda registros de cualquier tabla
     * @param Request $request = todos los datos a guardar
     * @return json con el mensaje de guardado y los datos
     */
    public function _store(Request $request)
    {
        try{
            //consulto los permisos
            if (($this->checkPermission('store.'.$this->name)) == false ) {
                return  response()->json(["message" => "no tienes permiso store.$this->name"], 403)
                    ->setStatusCode(403, 'no tienes permiso para crear registros de este modulo');
            }

            if (count($this->data) == 0) {
                $this->data = $request->all();
            }
            //si todo es correcto, guarda los datos

            if($this->object = $this->model::create($this->data)){
                return  response()->json(["message" => "Registro guardado con exito"], 201)
                    ->setStatusCode(201, 'Registro guardado con exito');
            }

            //si salta una exception la procesa
        }catch (\Exception $e){
            Log::critical("Error, archivo de error: {$e->getFile()}, linea del error: {$e->getLine()}, el error: {$e->getMessage()}");
            return  response()->json(["message" => "Error al intentar guardar"], 500)
                ->setStatusCode(500, 'Error al intentar guardar');
        }
    }

    /**
     * metodo que actualiza registros de cualquier tabla
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_fk = valor de la llave primaria por la que va a consultar
     * @param $g_status = nombre del campo status
     * @param Request $request
     * @return json con la respuesta de la actualizacion y los datos
     */
    public function _update($g_namePrimaryKey, $x_pk, $g_status, Request $request)
    {
        try {
            //consulto los permisos
            if (($this->checkPermission('update.'.$this->name)) == false ) {
                return  response()->json(["message" => "no tienes permiso update.$this->name"], 403)
                    ->setStatusCode(403, 'no tienes permiso para modificar registros de este modulo');
            }
            $this->object = $this->findTatuco($g_namePrimaryKey, $x_pk, $g_status); //consulto el registro
            //si el objeto es nulo, no existe la busqueda
            if (!$this->object) {
                return  response()->json(["message" => $this->name . ' no existe'], 404)
                    ->setStatusCode(404, $this->name . ' no existe');
            }

            $this->data = $request->all();
            if (!$this->object->update($this->data)){
                return  response()->json(["message" => "no se pudo modificar"], 404)
                    ->setStatusCode(404, "no se pudo modificar");
            }

            return  response()->json(["message" => "Registro modificado con exito"], 201)
                ->setStatusCode(201, 'Registro modificado con exito');



        }catch(\Exception $e){
            Log::critical("Error, archivo del error: {$e->getFile()}, linea del error: {$e->getLine()}, el error: {$e->getMessage()}");
            return  response()->json(["message" => "Error al intentar modificar"], 500)
                ->setStatusCode(500, 'Error al intentar modificar');
        }
    }

    /**
     * metodo que elimina logicamente registros de cualquier tabla
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_fk = valor de la llave primaria por la que va a consultar
     * @param $g_status = nombre del campo status
     * @return json con la respuesta de la eliminacion
     */
    public function _destroy($g_namePrimaryKey, $x_pk, $g_status)
    {
        try {
            //consulto los permisos
            if (($this->checkPermission('delete.'.$this->name)) == false ) {
                return  response()->json(["message" => "no tienes permiso delete.$this->name"], 403)
                    ->setStatusCode(403, 'no tienes permiso para eliminar registros de este modulo');
            }
            $this->object = $this->findTatuco($g_namePrimaryKey, $x_pk, $g_status); //consulto el registro
            //si el objeto es nulo, no existe la busqueda
            if (!$this->object) {
                return response()->json([
                    'message' => $this->name . ' no existe'
                ], 404);
            }
            //iguala el estatus a false = eliminado
            $this->object->$g_status = false;
            $this->object->update();
            return  response()->json(["message" => "Registro eliminado con exito"], 201)
                ->setStatusCode(201, 'Registro eliminado con exito');
        }catch (\Exception $e){
            Log::critical("Error, archivo del error: {$e->getFile()}, linea del error: {$e->getLine()}, el error: {$e->getMessage()}");
            return  response()->json(["message" => "Error al intentar eliminar"], 500)
                ->setStatusCode(500, 'Error al intentar eliminar');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * metodo para realizar respaldo a la base de datos
     * llamando al comando schedule:run de laravel
     * para que ejecute las tareas pendientes
     */
    public function backup()
    {

        try {
            if((\Artisan::call('schedule:run', array()))==0){
                return response()->json([
                    'status' => true,
                    'message' => 'Backup Existoso'
                ],200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Backup Fallido'
                ],500);
            }
        }catch (\Exception $e){
            Log::critical("Error, archivo del error: {$e->getFile()}, linea del error: {$e->getLine()}, el error: {$e->getMessage()}");
            return response()->json(["message"=>"Error de servidor"], 500);
        }
    }

    /**
     * metodo que busca en cualquier tabla a traves de la llave primaria
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_fk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @return los datos del usuario encontrado
     */
    public function findTatuco($g_namePrimaryKey, $x_fk, $g_status, $all = ['*'])
    {
        //consulto al usuario que esta logueado
        $user = $this->currentUSer();
        return $this->model->where($g_namePrimaryKey, $x_fk)
            ->where($g_status,true)
            ->where('acc_id',$user->acc_id)
            ->first($all);
    }

    /**
     * metodo que consulta los permisos que tiene el usuario
     * @param $permissions = nombre del permiso a consultar, ejem: index.user
     * @return bool
     */
    public function checkPermission($permissions)
    {
        if (!\JWTAuth::parseToken()->authenticate()->can($permissions)) {
            return false;
        }
        return true;
    }

    /**
     * metodo que consulta los datos del usuario logueado
     * @return el usuario logueado o null
     */
    public function currentUSer()
    {
        $user = \JWTAuth::parseToken()->authenticate();
        if($user){
            return $user;
        }

        return null;
    }

    /**
     * metodo que consulta los status dependiendo del la entidad, 1=user...
     * @param $x_tabStatus = valor de sta_tab ejem: 1=user...
     * @return json con los status segun la entidad
     */
    public function status($x_entity)
    {
        //llama a userService
        //consulto el account logueado
        $user = $this->currentUSer();
        $select = Status::select('sta_id as value','sta_des as text')
            ->where('acc_id',$user->acc_id)
            ->where('sta_tab',$x_entity)
            ->where('sta_act',true)
            ->get();

        return response()->json($select, 200);
    }
}

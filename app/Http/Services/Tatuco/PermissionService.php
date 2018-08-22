<?php

namespace App\Http\Services\Tatuco;

use App\Acl\src\Models\Permission;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
class PermissionService extends TatucoService
{

	public function __construct()
    {
        $this->name = 'permission';
        $this->model = new Permission();
        $this->namePlural = 'permissions';
    }

    /**
     * @return json con los datos de permissions
     */
    public function index(Request $request){

        //consulto los permisos
        if (($this->checkPermission('index.'.$this->name)) == false ) {
            return (new response())->setStatusCode(403, 'no tienes permiso para listar registros de este modulo');
        }

        $query = Permission::query()
            ->get();

        return response()->json($query, 200);
    }

    /**
     * @param $request
     * @return _store de tatucoService
     */
    public function store($request)
    {
    	return $this->_store($request);
    }

    /**
     * @param $x_pk = id del permiso
     * @return json con los datos de la consulta
     */
    public function show($x_pk)
    {
        //consulto los permisos
        if (($this->checkPermission('show.'.$this->name)) == false ) {
            return (new response())->setStatusCode(403, 'no tienes permiso para ver registros de este modulo');
        }
        //realizo el query
        $query = Permission::find($x_pk);

        //si el query no devuelve nada
        if(!$query)
        {
            return response()->json(['message'=>"Permiso". ' no existe'], 404);
        }
        //si consigue, arma el json
        return response()->json([
            'status'=>true,
            'message'=> "Permiso". ' Encontrado',
            "Permiso" => $query,
        ], 200);
    }


    /**
     * @param $x_pk = valor de la llave primaria
     * @param $request
     * @return update de tatucoService
     */
    public function update($x_pk, $request)
    {
        //llama a tatucoService
    	return $this->_update($x_pk, $request);
    }
}
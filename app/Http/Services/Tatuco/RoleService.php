<?php

namespace App\Http\Services\Tatuco;

use App\Acl\src\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RoleService extends TatucoService
{

	public function __construct()
    {
        $this->name = 'role';
        $this->model = new Role();
        $this->namePlural = 'roles';
    }

    /**
     * @return json con la consulta
     */
    public function index(Request $request)
    {
        $user = $this->currentUSer();
        //consulto los permisos
        if (($this->checkPermission('index.'.$this->name)) == false ) {
            return (new response())->setStatusCode(403, 'no tienes permiso index.'.$this->name);
        }


        $query = Role::query()
        ->where('acc_id',$user->acc_id);
        $items = $query->get();

        return response()->json($items, 200);
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
     * @param $x_pk  = valor de la llave primaria
     * @return json con el registro consultado
     */
    public function show($x_pk)
    {
        //consulto los permisos
        if (($this->checkPermission('show.'.$this->name)) == false ) {
            return (new response())->setStatusCode(403, 'no tienes permiso show.'.$this->name);
        }

        //realizo el query
        $query = Role::find($x_pk);


        return response()->json([
            'status'=>true,
            'message'=> "Rol". ' Encontrado',
            "Rol" => $query,
        ], 200);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param $request
     * @return json
     */
    public function update($x_pk, $request)
    {
    	return $this->_update($x_pk, $request);
    }

    /**
     * metodo que asigna el permiso a un rol
     * @param Request $request
     * @return json con el mensaje de asignacion del permiso
     */
    public function assignedPermission(Request $request)
    {
        try{
            $roleId=$request->json(['role']);
            $permissionId=$request->json(['permission']);
            $rol=Role::find($roleId);
            $rol->assignPermission($permissionId);
            if($rol->save()){
                Log::info('Permiso Asignado');
                return response()->json([
                    'status' => true,
                    'message' => 'Permiso Asignado '
                ], 200);
            }
        }catch (Exception $e){
            Log::critical("Error, archivo del peo: {$e->getFile()}, linea del peo: {$e->getLine()}, el peo: {$e->getMessage()}");
            return response()->json(["msj"=>"Error de servidor"], 500);
        }
    }

    /**
     * metodo que quita el permiso a un rol
     * @param $x_idRole = id del rol
     * @param $x_idPermission = id del permiso
     * @return json con el mensaje de rol revocado
     */
    public function revokePermission($x_idRole, $x_idPermission)
    {
        try{
            $role = Role::find($x_idRole);
            if($role->revokePermission($x_idPermission)){
                Log::info('Permiso Revocado');
                return response()->json([
                    'status' => true,
                    'msj' => 'Permiso Revocado '
                ], 200);
            }
        }catch (Exception $e){
            Log::critical("Error, archivo del peo: {$e->getFile()}, linea del peo: {$e->getLine()}, el peo: {$e->getMessage()}");
            return response()->json(["msj"=>"Error de servidor"], 500);
        }
    }

    /**
     * metodo que consulta los roles para el comboselect del front
     * @return json con los roles
     */
    public function selectRoles(){
        $user = $this->currentUSer();
        $select = Role::select('id as value','name as text')
            ->where('acc_id',$user->acc_id)
            ->get();

        return response()->json($select, 200);
    }
	
}
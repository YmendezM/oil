<?php

namespace App\Http\Controllers\Tatuco;


use App\Acl\src\Models\Permission;
use App\Acl\src\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Tatuco\RoleService;

class RoleController extends TatucoController
{
     public function __construct()
    {
        $this->service = new RoleService();
    }

    /**
     * @return index de roleService
     */
    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    /**
     * @param Request $request
     * @return store de roleService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($x_pk)
    {
        return $this->service->show($x_pk);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de roleService
     */
    public function update($x_pk, Request $request)
    {
      return $this->service->update($x_pk, $request);
    }

    /**
     * @param Request $request
     * @return assignedPermission de roleService
     */
    public function assignedPermission(Request $request)
    {
        return $this->service->assignedPermission($request);
    }

    /**
     * @param $x_idRole = id del rol
     * @param $x_idPermission = id del permiso
     * @return json con el mensaje del rol revocado
     */
    public function revokePermission($x_idRole, $x_idPermission)
    {
        return $this->service->revokePermission($x_idRole, $x_idPermission);
    }

    /**
     * @return selectRoles de roleService
     */
    public function selectRoles(){
        return $this->service->selectRoles();

    }
}

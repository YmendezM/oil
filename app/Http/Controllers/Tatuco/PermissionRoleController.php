<?php

namespace App\Http\Controllers\Tatuco;

use App\Http\Services\Tatuco\PermissionRoleService;
use Illuminate\Http\Request;

class PermissionRoleController extends TatucoController
{
    public function __construct()
    {
        $this->service = new PermissionRoleService();
    }

    /**
     * @return index de permissionRoleService
     */
    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    /**
     * @param Request $request
     * @return store permissionRoleService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }


    /**
     * @param $x_pk = id del permiso
     * @param Request $request
     * @return update de permissionRoleService
     */
    public function update($x_pk, Request $request)
    {
        //envia datos a permissionService
        return $this->service->update($x_pk, $request);
    }
}

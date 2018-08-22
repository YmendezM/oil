<?php

namespace App\Http\Controllers\Tatuco;

use App\Acl\src\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Services\Tatuco\PermissionService;

class PermissionController extends TatucoController
{
    

   public function __construct()
    {
        $this->service = new PermissionService();
    }

    /**
     * @return index de permissionService
     */
    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    /**
     * @param Request $request
     * @return store permissionService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }


    /**
     * @param $x_pk = id del permiso
     * @param Request $request
     * @return update de permissionService
     */
    public function update($x_pk, Request $request)
    {
        //envia datos a permissionService
        return $this->service->update($x_pk, $request);
    }
}

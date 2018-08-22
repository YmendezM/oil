<?php

namespace App\Http\Controllers\Tatuco;

use App\Http\Requests\UserRequest;
use App\Http\Services\Tatuco\RoleService;
use App\Http\Services\Tatuco\UserService;
use App\Models\Tatuco\User;
use Illuminate\Http\Request;

class UserController extends TatucoController
{
    //use RegistersUsers;

    /**
     * UserController constructor.
     * construimos los atributos que usara TatucoController
     */
    public $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->service = new UserService();
        $this->roleService = $roleService;
        $this->namePrimaryKey = 'use_dni';//llave primaria
        $this->status = 'use_act';//campo de activo o eliminado
    }

    /**
     * @return index de userService
     */
    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    /**
     * @param Request $request
     * @return store de userService
     */
    public function show($x_pk)
    {
        return $this->service->show($this->namePrimaryKey, $x_pk, $this->status);
    }

    /**
     * @param Request $request
     * @return store de userService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de userService
     */
    public function update($x_pk, Request $request)
    {
      return $this->service->update($this->namePrimaryKey, $x_pk, $this->status, $request);
    }

    /**
     * asigna el rol a un usuario
     * @param Request $request
     * @return assignedRole de userService
     */
    public function assignedRole(Request $request)
    {
        $idUser = $request->json(['user']);
        $idRole = $request->json(['role']);
        if(!$user=User::find($idUser)){
            return response()->json([
                'status' => false,
                'message' => 'El usuario no Existe'
            ],404);
        }

        return $this->service->assignedRole($idUser, $idRole);
    }

    /**
     * quita el rol a un usuario
     * @param Request $request
     * @param $idUser = id del usuario
     * @param $idRole = id del rol
     * @return \Illuminate\Http\JsonResponse
     */
    public function revokeRole(Request $request, $idUser, $idRole)
    {

        if($this->service->findByItem($idUser)) {
            if ($this->roleService->findByItem($idRole)){
                return $this->service->revokeRole($idUser, $idRole);
            }
            return $this->service->notFound();
        }else{
            return $this->service->notFound('Usuario');
        }
    }

}

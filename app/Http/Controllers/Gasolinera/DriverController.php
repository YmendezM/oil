<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Requests\DriverRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\DriverService;

class DriverController extends TatucoController
{
    public function __construct()
    {
        $this->service = new DriverService();
        $this->namePrimaryKey = 'dri_dni';//llave primaria
        $this->status = 'dri_act';//campo de activo o eliminado
    }

    /**
     * @return index de driverService
     */
    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    /**
     * @param Request $request
     * @return store de driverService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de driverService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey, $x_pk, $this->status, $request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @return destroy de driverService
     */
    public function destroy($x_pk)
    {
        //llama a userService
        return $this->service->destroy($this->namePrimaryKey, $x_pk, $this->status);
    }

}

<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\TypeVehicleService;
use Illuminate\Http\Request;

class typeVehicleController extends TatucoController
{
    public function __construct()
    {
        $this->service = new TypeVehicleService();
        $this->namePrimaryKey = 'tve_id';//llave primaria
        $this->status = 'tve_act';//campo de activo o eliminado
    }

    /**
     * @param Request $request
     * @return store de TypeVehicleService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de TypeVehicleService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }

    /**
     * @return selectTypes de TypeVehicleService
     */
    public function selectTypes()
    {
        return $this->service->selectTypes();
    }
}

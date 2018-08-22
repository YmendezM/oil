<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\TypeFuelService;
use Illuminate\Http\Request;

class TypeFuelController extends TatucoController
{
    public function __construct()
    {
        $this->service = new TypeFuelService();
        $this->namePrimaryKey = 'tfu_id';//llave primaria
        $this->status = 'tfu_act';//campo de activo o eliminado
    }

    /**
     * @param Request $request
     * @return store TypeFuelService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de TypeFuelService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }

    /**
     * @param
     * @return selectTypes de TypefuelService
     */
    public function selectTypes(){
        //llama a vehicleService
        return $this->service->selectTypes();

    }
}

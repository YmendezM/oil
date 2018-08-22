<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\FuelService;
use Illuminate\Http\Request;

class FuelController extends TatucoController
{
    public function __construct()
    {
        $this->service = new FuelService();
        $this->namePrimaryKey = 'fue_id';//llave primaria
        $this->status = 'fue_act';//campo de activo o eliminado
    }

    /**
     * @param Request $request
     * @return store de fuelService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de fuelService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }

    /**
     * @param $x_TypeFuel = id del typeFuels
     * @return selectFuels de fuelService
     */
    public function selectFuels($x_typeFuel){
        //llama a vehicleService
        return $this->service->selectFuels($x_typeFuel);

    }
}

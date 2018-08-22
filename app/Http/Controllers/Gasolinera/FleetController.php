<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\FleetService;
use App\Models\Gasolinera\Fleet;
use Illuminate\Http\Request;

class FleetController extends TatucoController
{
    public function __construct()
    {
        $this->service = new FleetService();
        $this->namePrimaryKey = 'fle_id';//llave primaria
        $this->status = 'fle_act';//campo de activo o eliminado
    }

    /**
     * @param Request $request
     * @return store de fleetService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de fleetService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @return destroy de vehicleService
     */
    public function destroy($x_pk)
    {
        return $this->service->destroy($this->namePrimaryKey, $x_pk, $this->status);
    }

    /**
     * @return selectFleets de fleetService
     */
    public function selectFleets()
    {
        return $this->service->selectFleets();
    }
}

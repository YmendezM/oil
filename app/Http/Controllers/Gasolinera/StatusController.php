<?php

namespace App\Http\Controllers\Gasolinera;

use Illuminate\Http\Request;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\StatusService;
use App\Models\Gasolinera\Status;

class StatusController extends TatucoController
{
    public function __construct()
    {
        $this->service = new StatusService();
        $this->campo = 'sta_id';//llave primaria
        $this->status = 'sta_act';//campo de activo o eliminado
    }

    /**
     * @param Request $request
     * @return store de statusService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update statusService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($x_pk, $this->status, $request);
    }

    /**
     * @return status de tatucoService
     */
    public function statusVehicle()
    {
        return $this->service->status(3);
    }

    /**
     * @return status de tatucoService
     */
    public function statusDriver()
    {
        return $this->service->status(2);
    }

    /**
     * @return status de tatucoService
     */
    public function statusUser()
    {
        return $this->service->status(1);
    }
}

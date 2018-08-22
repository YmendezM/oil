<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends TatucoController
{
    public function __construct()
    {
        $this->service = new NotificationService();
        $this->namePrimaryKey = 'not_id';//llave primaria
        $this->status = 'not_act';//campo de activo o eliminado
    }

    /**
     * @param Request $request
     * @return store de NotificationService
     */
    public function store(Request $request)
    {
        //llama a userService
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = nombre de la llave primaria
     * @param Request $request
     * @return update de NotificationService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }

    /**
     * @return alertDriver de NotificationService
     */
    public function alertDriver()
    {
        return $this->service->alertDriver();
    }

    /**
     * @return alertVehicle de NotificationService
     */
    public function alertVehicle()
    {
        return $this->service->alertVehicle();
    }
}

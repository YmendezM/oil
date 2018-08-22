<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\ModelVehicleService;
use App\Models\Gasolinera\ModelVehicle;
use Illuminate\Http\Request;

class ModelVehicleController extends TatucoController
{
    public function __construct()
    {
        $this->service = new ModelVehicleService();
        $this->namePrimaryKey = 'mod_id';//llave primaria
        $this->status = 'mod_act';//campo de activo o eliminado
    }

    /**
     * @param Request $request
     * @return store de modelVehicleService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de modelVehicleService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }

    /**
     * @param $x_idBrand = id del brandVehicle
     * @return selectModels de modelVehicleService
     */
    public function selectModels($x_idBrand){
        //llama a vehicleService
        return $this->service->selectModels($x_idBrand);

    }

    /**
     * @return selectModelsAll de modelVehicleService
     */
    public function selectModelsAll(){

        return $this->service->selectModelsAll();
    }
}

<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\BrandVehicleService;
use App\Models\Gasolinera\BrandVehicle;
use Illuminate\Http\Request;

class BrandVehicleController extends TatucoController
{
    public function __construct()
    {
        $this->service = new BrandVehicleService();
        $this->namePrimaryKey = 'bra_id';//llave primaria
        $this->status = 'bra_act';//campo de activo o eliminado
    }

    /**
     * @param Request $request
     * @return store de brandVehicleService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de brandVehicleService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey, $x_pk, $this->status, $request);
    }

    /**
     * metodo para comboselect de brands
     * @return selectBrands de brandVehicleService
     */
    public function selectBrands()
    {
        return $this->service->selectBrands();
    }
}

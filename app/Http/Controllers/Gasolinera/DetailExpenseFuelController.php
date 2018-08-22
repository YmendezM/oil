<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\DetailExpenseFuelService;
use Illuminate\Http\Request;
class DetailExpenseFuelController extends TatucoController
{
    public function __construct()
    {
        $this->service = new DetailExpenseFuelService();
        $this->namePrimaryKey = 'dex_id';//llave primaria
        $this->status = 'dex_act';//campo de activo o eliminado
    }

    /**
     * @param Request $request
     * @return store de DetailExpenseFuelService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return  update DetailExpenseFuelService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }
}

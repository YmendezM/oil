<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\AuditService;
use Illuminate\Http\Request;

class AuditController extends TatucoController
{
    public function __construct()
    {
        $this->service = new AuditService();
        $this->namePrimaryKey = 'aud_id';//llave primaria
        $this->status = 'aud_act';//campo de activo o eliminado
    }


    /**
     * @param Request $request
     * @return store de AuditService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de AuditService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }
}

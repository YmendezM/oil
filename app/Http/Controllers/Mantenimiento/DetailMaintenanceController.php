<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Mantenimiento\DetailMaintenanceService;
use Illuminate\Http\Request;

class DetailMaintenanceController extends TatucoController
{
    public function __construct()
    {
        $this->service = new DetailMaintenanceService();
        $this->namePrimaryKey = 'dma_id';//llave primaria
        $this->status = 'dma_act';//campo de activo o eliminado
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

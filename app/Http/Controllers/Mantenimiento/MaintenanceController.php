<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Mantenimiento\MaintenanceService;
use Illuminate\Http\Request;

class MaintenanceController extends TatucoController
{
    public function __construct()
    {
        $this->service = new MaintenanceService();
        $this->namePrimaryKey = 'mai_id';//llave primaria
        $this->status = 'mai_act';//campo de activo o eliminado
    }

    /**
     * @return index de MaintenanceService
     */
    public function index(Request $request)
    {
        return $this->service->index($request);
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

    /**
     * @param $x_veh_pla = placa del vehiculo
     * @param $x_flag = bandera para saber que el front consulta el gps
     * @return consultGps de maintenanceService
     */
    public function consultGps($x_veh_pla, $x_flag)
    {
        return $this->service->consultGps($x_veh_pla, $x_flag);
    }

    public function statusMaintenance($x_veh_pla)
    {
        return $this->service->statusMaintenance($x_veh_pla);
    }
}
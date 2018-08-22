<?php
namespace app\Http\Services\Mantenimiento;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Mantenimiento\DetailMaintenance;
use Illuminate\Http\Request;



class DetailMaintenanceService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'detail_maintenance';
        $this->model = new DetailMaintenance();
        $this->namePlural = 'detail_maintenances';
    }

    /**
     * @param Request $request
     * @return _store de tatucoService
     */
    public function store(Request $request)
    {
        return $this->_store($request);
    }

    /**
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @param Request $request
     * @return _update de tatucoService
     */
    public function update($g_namePrimaryKey, $x_pk, $g_status, Request $request)
    {
        return $this->_update($g_namePrimaryKey, $x_pk, $g_status, $request);
    }

    /**
     * @param $x_id = id de maintenance
     * @param $x_acc = account de la operacion
     * @return id creado del detalle
     */
    public function storeDetail($x_id, $x_user,  $x_acc)
    {
        //guardo el detail_expense_fuel
        $detail = new DetailMaintenance();
        $detail->mai_id = $x_id;
        $detail->use_nic = $x_user;
        $detail->dsm_id = 1;
        $detail->acc_id = $x_acc;
        $detail->save();

        //agarro el id
        $id = $detail->dma_id;
        return $id;
    }
}
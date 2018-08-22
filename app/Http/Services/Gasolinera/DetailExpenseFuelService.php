<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\DetailExpenseFuel;
use Illuminate\Http\Request;

class DetailExpenseFuelService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'detail_expense_fuel';
        $this->model = new DetailExpenseFuel();
        $this->namePlural = 'details_expenses_fuels';
    }

    /**
     * @param $request
     * @return _store de tatucoService
     */
    public function store($request)
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
}
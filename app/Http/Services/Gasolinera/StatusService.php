<?php

namespace app\Http\Services\Gasolinera;

use App\Models\Gasolinera\Status;
use App\Http\Services\Tatuco\TatucoService;
use Illuminate\Http\Request;

class StatusService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'status';
        $this->model = new Status();
        $this->namePlural = 'status';
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

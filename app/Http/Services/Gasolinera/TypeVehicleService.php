<?php

namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\TypeVehicle;
use Illuminate\Http\Request;

class TypeVehicleService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'type_vehicle';
        $this->model = new TypeVehicle();
        $this->namePlural = 'types_vehicles';
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
     * metodo que consulta todos los typeVehicles
     * @return json con el listado para comboselect de typesVehicles
     */
    public function selectTypes()
    {
        $user = $this->currentUSer();
        $select = TypeVehicle::select('tve_id as value','tve_des as text')
            ->where('acc_id',$user->acc_id)
            ->where('tve_act',true)
            ->get();

        return response()->json($select, 200);
    }
}
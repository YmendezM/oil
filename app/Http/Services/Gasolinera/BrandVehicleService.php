<?php

namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\BrandVehicle;
use Illuminate\Http\Request;

class BrandVehicleService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'brand_vehicle';
        $this->model = new BrandVehicle();
        $this->namePlural = 'brands_vehicles';
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
     * consulta para un comboselect de brands
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectBrands()
    {
        //consulto al usuario que esta logueado
        $user = $this->currentUSer();
        $select = BrandVehicle::select('bra_id as value','bra_des as text')
            ->where('acc_id',$user->acc_id)
            ->where('bra_act',true)
            ->get();

        return response()->json($select, 200);
    }
}
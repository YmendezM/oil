<?php

namespace app\Http\Services\Gasolinera;


use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\ModelVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelVehicleService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'model_vehicle';
        $this->model = new ModelVehicle();
        $this->namePlural = 'model_vehicles';
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
     * metodo que consulta todos los models dependiendo del brand
     * @param $x_idBrand = id del BrandVehicle
     * @return json con todos los models filtrados
     */
    public function selectModels($x_idBrand){

        $user = $this->currentUSer();
        //select con el query armado en el service anterior
        $query = ModelVehicle::select('mod_id as value','mod_des as text')
            ->where('acc_id',$user->acc_id)
            ->where('mod_act',true)
            ->where('bra_id', $x_idBrand)
            ->get();

        return response()->json($query, 200);

    }

    /**
     * metodo que consulta todos los modelos
     * @return json con todos los modelos
     */
    public function selectModelsAll()
    {
        //consulto el account logueado
        $user = $this->currentUSer();
        $select = ModelVehicle::select('mod_id as value','mod_des as text')
                ->where('acc_id',$user->acc_id)
                ->where('mod_act',true)
                ->get();

        return response()->json($select, 200);
    }
}
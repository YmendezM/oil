<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\TypeFuel;
use Illuminate\Http\Request;

class TypeFuelService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'type_fuel';
        $this->model = new TypeFuel();
        $this->namePlural = 'types_fuel';
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
     * @return _update de tatucoSerice
     */
    public function update($g_namePrimaryKey, $x_pk, $g_status, Request $request)
    {
        //envio a tatuco service
        return $this->_update($g_namePrimaryKey, $x_pk, $g_status, $request);
    }

    /**
     * metodo que consulta el  tipo de combustible
     * @return json con los tipos de combustibles
     */

    public function selectTypes(){

        $user = $this->currentUSer();

        $query = TypeFuel::select('tfu_id as value','tfu_des as text')
        ->where('tfu_act',true)
        ->where('acc_id',$user->acc_id)
        ->get();

        return response()->json($query, 200);

    }
}
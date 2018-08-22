<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\Fuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuelService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'fuel';
        $this->model = new Fuel();
        $this->namePlural = 'fuels';
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
     * @param $x_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @param Request $request
     * @return _update de tatucoService
     */
    public function update($x_namePrimaryKey, $x_pk, $g_status, Request $request)
    {
        return $this->_update($x_namePrimaryKey, $x_pk, $g_status, $request);
    }

    /**
     * metodo que consulta el combustible dependiendo del tipo
     * @param $x_TypeFuel = id de typeFuels
     * @return json con los combustibles dependiendo del tipo
     */
    public function selectFuels($x_TypeFuel){
        if($x_TypeFuel ==2){
            $data = [
                "value" => 2,
                "text" => "No aplica"
            ];

            return response()->json([$data], 200);
        }
        $user = $this->currentUSer();
        //select con el query armado en el service anterior
        $query = Fuel::select('fue_id as value','fue_oct as text')
            ->where('fue_act',true)
            ->where('acc_id',$user->acc_id)
            ->where('tfu_id',$x_TypeFuel)
            ->get();

        return response()->json($query, 200);

    }

    /**
     * metodo que convierte varias unidades de medida a litros
     * @param $x_qua = cantidad de combustible
     * @param $x_ume = unidad de medida ingresada
     * @return valor convertido a litros
     */
    public function convertFuel($x_qua, $x_ume)
    {
        switch ($x_ume){
            case 1: //litros
                return $x_qua;
                break;
            case 2: //galones
                $quantity = ($x_qua * 3.78541178)/1;
                return $quantity;
                break;
            case 3: //mililitros
                $quantity = ($x_qua / 1000);
                return $quantity;
                break;
            case 4: //centimetros cubicos
                $quantity = ($x_qua / 1000);
                return $quantity;
                break;
            default:
                return $x_qua;
                break;
        }
    }
}
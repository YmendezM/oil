<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\Fleet;
use App\Models\Gasolinera\Vehicle;
use Illuminate\Http\Request;


class FleetService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'fleet';
        $this->model = new Fleet();
        $this->namePlural = 'fleets';
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
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @return llama al tatucoService
     */
    public function destroy($g_namePrimaryKey, $x_pk, $g_status)
    {
        //consulto si la flota tiene un vehiculo asignado

        $fleet = Vehicle::where('fle_id',$x_pk)->first();
        if($fleet) {
            return response()->json(["message" => "No puedes eliminar la flota porque esta asociada a un vehiculo"], 500)
                ->setStatusCode(500, 'No puedes eliminar la flota porque esta asociada a un vehiculo');
        }
        //llama a tatucoService
        return $this->_destroy($g_namePrimaryKey, $x_pk, $g_status);
    }

    /**
     * metodo que consulta los fleets para el comboselect del front
     * @return json con los fleets
     */
    public function selectFleets()
    {
        //llama a vehicleService
        $user = $this->currentUSer();
        $select = Fleet::select('fle_id as value','fle_nam as text')
            ->where('acc_id',$user->acc_id)
            ->where('fle_act',true)
            ->get();

        return response()->json($select, 200);
    }
}

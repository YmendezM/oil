<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NotificationService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'notification';
        $this->model = new Notification();
        $this->namePlural = 'notifications';
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

    /**
     * metodo que consulta las alertas de drivers que superaron el limite diario de consumo
     * @return json con las alertas de drivers
     */
    public function alertDriver()
    {
        $user = $this->currentUSer();
        $data = DB::table("notifications as n")
            ->select('d.dri_dni','d.dri_nam','d.dri_lna', DB::raw("cast(format_numbers(n.not_cex) as numeric) as not_cex"),
                'n.created_at')
            ->join("drivers as d", "d.dri_dni", "=",'n.dri_dni')
            ->where("n.acc_id",$user->acc_id)
            ->where("d.dri_act",true)
            ->limit(10)
            ->get();


        return response()->json([
            "data"=> $data,
            "count"=> count($data)
        ], 200);

    }

    /**
     * metodo que consulta las alertas de vehicles que superaron el limite diario de consumo
     * @return json con las alertas de vehicles
     */
    public function alertVehicle()
    {
        $user = $this->currentUSer();
        $data = DB::table("notifications as n")
            ->select('v.veh_pla','b.bra_des','m.mod_des',DB::raw("cast(format_numbers(n.not_cex) as numeric) as not_cex"),
                'n.created_at')
            ->leftJoin("vehicles as v", "v.veh_pla", "=",'n.veh_pla')
            ->leftJoin("brands_vehicles as b", "b.bra_id", "=",'v.bra_id')
            ->leftJoin("models_vehicles as m", "m.mod_id", "=",'v.mod_id')
            ->where("n.acc_id",$user->acc_id)
            ->where("v.veh_act",true)
            ->limit(10)
            ->get();


        return response()->json([
            "data"=> $data,
            "count"=> count($data)
        ], 200);

    }

    /**
     *  metodo que guarda una notificacion si el vehiculo excede el consumo diario
     * @param $x_comMin = registro del consumo minimo del vehicle
     * @param $x_acc_id = account del vehicle
     * @param $x_placa = placa del vehicle
     * @param $x_vehCom = consumo realizado por el vehicle
     */
    public function notificationVehicle($x_comMin, $x_acc_id, $x_plate, $x_vehCom)
    {
        $day = Carbon::now()->format('d');
        $data = DB::table("expenses_fuels as ef")
            ->select(DB::raw("SUM(def.dex_qua) as count"))
            ->join("detail_expenses_fuels as def", "def.exp_id", "=", 'ef.exp_id')
            ->join("assignments as a", "a.ass_id", "=", 'ef.ass_id')
            ->join("vehicles as v", "v.veh_pla", "=", 'a.veh_pla')
            ->where("v.veh_pla", "=", $x_plate)
            ->whereDay('def.created_at', $day)
            ->groupBy("v.veh_pla")
            ->first();
        $count = $data->count;
        //si el consumo es mayor al establecido, inserto la notificacion
        if ($count > $x_comMin || $x_comMin > $x_vehCom) {
            $minus = ($count - $x_vehCom);
            $select = Notification::where("veh_pla", "=", $x_plate);

            if ($select) {
                DB::delete("delete from notifications where veh_pla = '$x_plate' and EXTRACT (DAY FROM created_at) = '$day'");
            }
            $noti = new Notification();
            $noti->not_des = "vehiculo";
            $noti->veh_pla = $x_plate;
            $noti->not_cmi = $x_vehCom;
            $noti->not_cex = $minus;
            $noti->acc_id = $x_acc_id;
            $noti->save();
        }
    }

    /**
     * metodo que inserta una notificacion si el driver excede el consumo minimo
     * @param $x_comMinimo = registro del consumo minimo del driver
     * @param $x_acc_id = account del driver
     * @param $x_dri = dni del driver
     * @param $x_driCom = consumo realizado por el driver
     */
    public function notificationDriver($x_comMin, $x_acc_id, $x_dri, $x_driCom)
    {
        $day = Carbon::now()->format('d');
        $data = DB::table("expenses_fuels as ef")
            ->select(DB::raw("SUM(def.dex_qua) as count"))
            ->join("detail_expenses_fuels as def", "def.exp_id", "=",'ef.exp_id')
            ->join("assignments as a", "a.ass_id", "=",'ef.ass_id')
            ->join("drivers as d", "d.dri_dni", "=",'a.dri_dni')
            ->where("d.dri_dni", "=",$x_dri)
            ->whereDay( 'def.created_at',$day)
            ->groupBy("d.dri_dni")
            ->first();
        $count = $data->count;
        //si el consumo es mayor al establecido, inserto la notificacion
        if($count > $x_comMin || $x_comMin > $x_driCom)
        {
            $minus = ($count - $x_driCom);
            $select = Notification::where("dri_dni","=",$x_dri);
            if($select){
                DB::delete("delete from notifications where dri_dni = '$x_dri' and EXTRACT (DAY FROM created_at) = '$day'");
            }
            $noti = new Notification();
            $noti->not_des = "conductor";
            $noti->dri_dni = $x_dri;
            $noti->not_cmi = $x_driCom;
            $noti->not_cex = $minus;
            $noti->acc_id = $x_acc_id;
            $noti->save();
        }
    }

}
<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\DetailExpenseFuel;
use App\Models\Gasolinera\ExpenseFuel;
use App\Models\Gasolinera\Fleet;
use App\Models\Gasolinera\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardService extends TatucoService
{

    public function __construct()
    {
        $this->name = 'dashboard';
    }

    /**
     * metodo que consulta el top de conductores del dashboard
     * @return json con el top 5 de vehiculos*
     */
    public function topDriver(){
        //consulto el account logueado
        $user =  $user = $this->currentUSer();
        //consulto mes en curso
        $month = Carbon::now()->format('m');
        $select = DB::table('expenses_fuels as ef')
            ->select('d.dri_dni', 'd.dri_nam', 'd.dri_lna', DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
            ->join('detail_expenses_fuels as def', 'def.exp_id','ef.exp_id')
            ->join('assignments as a', 'a.ass_id','ef.ass_id')
            ->join('drivers as d', 'd.dri_dni','a.dri_dni')
            ->whereMonth('ef.created_at',$month)
            ->where('ef.exp_act','=',true)
            ->where('ef.acc_id','=',$user->acc_id)
            ->groupBy('d.dri_dni')
            ->orderBy('sumatoria','desc')
            ->limit(5)
            ->get();

        return response()->json($select, 200);
    }


    /**
     * metodo que consulta el top de vehiculos del dashboard
     * @return json con el top 5 de vehiculos
     */
    public function topVehicle(){
        //consulto el account logueado
        $user = $user = $this->currentUSer();
        //consulto mes en curso
        $month = Carbon::now()->format('m');

        $select = DB::table('expenses_fuels as ef')
            ->select('v.veh_id', 'mo.mod_des', 'b.bra_des', DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
            ->leftJoin('detail_expenses_fuels as def', 'def.exp_id','ef.exp_id')
            ->leftJoin('assignments as a', 'a.ass_id','ef.ass_id')
            ->leftJoin('vehicles as v', 'v.veh_pla','a.veh_pla')
            ->leftJoin('models_vehicles as mo', 'mo.mod_id','v.mod_id')
            ->leftJoin('brands_vehicles as b', 'b.bra_id','v.bra_id')
            ->whereMonth('ef.created_at',$month)
            ->where('ef.exp_act','=',true)
            ->where('ef.acc_id','=',$user->acc_id)
            ->groupBy('v.veh_pla','mo.mod_des','b.bra_id')
            ->orderBy('sumatoria', 'desc')
            ->limit(5)
            ->get();

        return response()->json($select, 200);

    }


    /**
     * metodo que consulta los totales
     * @param $x_date = valor de la fecha
     * @return json con los totales
     */
    public function totalsDashboard($x_date)
    {
        $user = $this->currentUSer();
        $explode1 = explode('-',$x_date); //explode para saber si viene año-mes o solo año ejem 2018-01 ó solo 2018
        if(count($explode1)!=2) { //solo viene año
            $operationCount = ExpenseFuel::where('exp_act','=',true)
                ->where('acc_id','=',$user->acc_id)
                ->whereYear('created_at',$x_date)
                ->count();


            $fuelCount = ExpenseFuel::from('expenses_fuels as ef')
                ->select('def.dex_qua')
                ->join('detail_expenses_fuels as def', 'def.exp_id','ef.exp_id')
                ->where('ef.exp_act','=',true)
                ->where('ef.acc_id','=',$user->acc_id)
                ->whereYear('ef.created_at',$x_date)
                ->sum('def.dex_qua');

            //si consigue algo devuelve los datos
            return response()->json([
                "operationCount"=> $operationCount,
                "fuelCount"=> $fuelCount
            ], 200);
        }else{
            //si viene mes
            $operationCount = ExpenseFuel::where('exp_act','=',true)
                ->where('acc_id','=',$user->acc_id)
                ->whereYear('created_at',$explode1[0])
                ->whereMonth('created_at',$explode1[1])
                ->count();

            $fuelCount = ExpenseFuel::from('expenses_fuels as ef')
                ->select('def.dex_qua')
                ->join('detail_expenses_fuels as def', 'def.exp_id','ef.exp_id')
                ->where('ef.exp_act','=',true)
                ->where('ef.acc_id','=',$user->acc_id)
                ->whereYear('ef.created_at',$explode1[0])
                ->whereMonth('ef.created_at',$explode1[1])
                ->sum('def.dex_qua');

            //si consigue algo devuelve los datos
            return response()->json([
                "operationCount"=> $operationCount,
                "fuelCount"=> $fuelCount
            ], 200);
        }
    }


    /**
     * metodo que consulta los totales de operaciones para graficas
     * @param $x_date = valor de la fecha
     * @return json con los totales de operaciones para graficar
     */
    public function graphTotalOperationDashboard($x_date)
    {
        $user =  $user = $this->currentUSer();

        $explode1 = explode('-',$x_date); //explode para saber si viene año-mes o solo año ejem 2018-01 ó solo 2018
        if(count($explode1)!=2) { //solo viene año
            //si no viene mes
            $month = 12;
            $totalsOp = array();
            for($i =0; $i<$month; $i++){
                $select = ExpenseFuel::from('expenses_fuels')
                    ->whereYear('created_at',$x_date)
                    ->whereMonth('created_at',$i+1)
                    ->where('exp_act','=',true)
                    ->where('acc_id','=',$user->acc_id)
                    ->groupBy(DB::raw("EXTRACT(MONTH FROM created_at)"))
                    ->count();

                //si no existe nada en el mes, guardo 0
                if($select<1){
                    $select = 0;
                    array_push($totalsOp, $select);
                }else {
                    array_push($totalsOp, $select);
                }
            }
            //si consigue algo devuelve los datos
            return response()->json($totalsOp, 200);
        }else{
            //si viene mes
            $day = date("t",mktime(0,0,0,$explode1[1],1,$explode1[0]));  // saco la cantidad de dias del mes
            $totalsOp = array();
            for($i =1; $i<=$day; $i++){
                $created_at = "$explode1[0]-$explode1[1]-$i";
                $select = ExpenseFuel::from('expenses_fuels')
                    ->whereDate('created_at',$created_at)
                    ->where('exp_act','=',true)
                    ->where('acc_id','=',$user->acc_id)
                    ->groupBy(DB::raw("EXTRACT(DAY FROM created_at)"))
                    ->count();

                if($select<1){
                    $select = 0;
                    array_push($totalsOp, $select);
                }else {
                    array_push($totalsOp, $select);
                }
            }
            //si consigue algo devuelve los datos
            return response()->json($totalsOp, 200);
        }
    }

    /**
     * @param $x_date = valor de la fecha
     * @return json con los totales de combustibles dispensado para graficar
     */
    public function graphTotalExpensesDashboard($x_date)
    {
        $user =  $user = $this->currentUSer();
        $explode1 = explode('-',$x_date); //explode para saber si viene año-mes o solo año ejem 2018-01 ó solo 2018
        if(count($explode1)!=2) { //solo viene año
            //si no viene mes
            $month = 12;
            $totalsExp = array();
            for ($i = 0; $i <$month; $i++) {

                $select = DB::table('expenses_fuels as ef')
                    ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'), DB::raw("EXTRACT(MONTH FROM ef.created_at) as month"))
                    ->join('detail_expenses_fuels as def','def.exp_id','ef.exp_id')
                    ->whereYear('ef.created_at', $x_date)
                    ->whereMonth('ef.created_at', $i+1)
                    ->where('ef.exp_act', '=', true)
                    ->where('ef.acc_id', '=', $user->acc_id)
                    ->groupBy('month')
                    ->get();


                //si no existe nada en el mes, guardo 0
                if (count($select) < 1) {
                    $select = 0;
                    array_push($totalsExp, $select);
                } else {
                    foreach ($select as $ope) {
                        array_push($totalsExp, abs($ope->sumatoria));
                    }
                }

            }
            //si consigue algo devuelve los datos
           return response()->json($totalsExp, 200);
        }else{
            //si viene mes
            $day = date("t",mktime(0,0,0,$explode1[1],1,$explode1[0]));  // saco la cantidad de dias del mes
            $totalsExp = array();
            for ($i = 1; $i <=$day; $i++) {
                $created_at = "$explode1[0]-$explode1[1]-$i";
                $select = DB::table('expenses_fuels as ef')
                    ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'),DB::raw('EXTRACT(DAY FROM ef.created_at)'))
                    ->join('detail_expenses_fuels as def', 'ef.exp_id', 'def.exp_id')
                    ->whereDate('ef.created_at', $created_at)
                    ->where('ef.exp_act', '=', true)
                    ->where('ef.acc_id', '=', $user->acc_id)
                        ->groupBy(DB::raw('EXTRACT(DAY FROM ef.created_at)'))
                    ->get();
                //si no existe nada en el mes, guardo 0
                if (count($select) < 1) {
                    $select = 0;
                    array_push($totalsExp, $select);
                } else {
                    foreach ($select as $ope) {
                        array_push($totalsExp, abs($ope->sumatoria));
                    }
                }
            }

            //si consigue algo devuelve los datos
            return response()->json($totalsExp, 200);
        }
    }

    /**
     * grafico de barras con los consumos de vehiculos por id de vehiculo
     * @param $x_date = valor de la fecha
     * @param $x_convert = bandera para convertir, si viene 1 lo deja en litros, si viene 2 convierte litros a galones
     * @return json con los consumos de combustibles dispensado por id
     */
    public function graphVehicleConsumption($x_date, $x_convert, $x_fleet)
    {
        $user =  $user = $this->currentUSer();

        if(!Fleet::find($x_fleet) && $x_fleet){
            return  response()->json(["message" => "La Flota por la que esta filtrando no existe"], 500)
                ->setStatusCode(500, 'La Flota por la que esta filtrando no existe');
        }
        $explode1 = explode('-',$x_date); //explode para saber si viene año-mes o solo año ejem 2018-01 ó solo 2018
        if(count($explode1)!=2) {
            $select = DB::table('expenses_fuels as ef')
                ->select('v.veh_id', DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
                ->leftJoin('detail_expenses_fuels as def', 'def.exp_id', 'ef.exp_id')
                ->leftJoin('assignments as a', 'a.ass_id', 'ef.ass_id')
                ->leftJoin('vehicles as v', 'v.veh_pla', 'a.veh_pla')
                ->whereYear('ef.created_at', $x_date)
                ->where('ef.exp_act', '=', true)
                ->if($x_fleet, 'v.fle_id', '=', $x_fleet) //si viene placa filtro por placa sino por todos
                ->where('ef.acc_id', '=', $user->acc_id)
                ->groupBy('v.veh_id')
                ->orderBy('sumatoria', 'desc')
                ->get();

            if($x_convert == 2){//si viene 2 convierto de litros a galones
                foreach ($select as $sel){
                   $sel->sumatoria = $sel->sumatoria * 0.26417;
                    $sel->sumatoria = round($sel->sumatoria, 4);
                }
            }
            //si consigue algo devuelve los datos
            return response()->json($select, 200);
        }else{
            //si viene mes
            $select = DB::table('expenses_fuels as ef')
                ->select('v.veh_id', DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
                ->leftJoin('detail_expenses_fuels as def', 'def.exp_id','ef.exp_id')
                ->leftJoin('assignments as a', 'a.ass_id','ef.ass_id')
                ->leftJoin('vehicles as v', 'v.veh_pla','a.veh_pla')
                ->whereYear('ef.created_at',$explode1[0])
                ->whereMonth('ef.created_at',$explode1[1])
                ->where('ef.exp_act','=',true)
                ->if($x_fleet, 'v.fle_id', '=', $x_fleet) //si viene placa filtro por placa sino por todos
                ->where('ef.acc_id','=',$user->acc_id)
                ->groupBy('v.veh_id')
                ->orderBy('sumatoria', 'desc')
                ->get();

            if($x_convert == 2){//si viene 2 convierto de litros a galones
                foreach ($select as $sel){
                    $sel->sumatoria = $sel->sumatoria * 0.26417;
                    $sel->sumatoria = round($sel->sumatoria, 4);
                }
            }
            //si consigue algo devuelve los datos
            return response()->json($select, 200);
        }
    }

    /**
     * grafico de barras con los consumos de vehiculos por flota
     * @param $x_date = valor de la fecha
     * @param $x_convert = bandera para convertir, si viene 1 lo deja en litros, si viene 2 convierte litros a galones
     * @return json con los consumos de combustibles dispensado por flota
     */
    public function graphFleetConsumption($x_date, $x_convert)
    {
        $user =  $user = $this->currentUSer();
        $fleet = Fleet::where('fle_act',true)
            ->where('acc_id',$user->acc_id)
            ->get();
        $explode1 = explode('-',$x_date); //explode para saber si viene año-mes o solo año ejem 2018-01 ó solo 2018
        if(count($explode1)!=2) { //solo viene año
            $totalsExp = array();
            for ($i = 0; $i <count($fleet); $i++) {
                $select = DB::table('expenses_fuels as ef')
                    ->select('f.fle_nam', DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
                    ->leftJoin('detail_expenses_fuels as def', 'def.exp_id', 'ef.exp_id')
                    ->leftJoin('assignments as a', 'a.ass_id', 'ef.ass_id')
                    ->leftJoin('vehicles as v', 'v.veh_pla', 'a.veh_pla')
                    ->leftJoin('fleets as f', 'f.fle_id', 'v.fle_id')
                    ->whereYear('ef.created_at', $x_date)
                    ->where('ef.exp_act', '=', true)
                    ->where('f.fle_id', '=', $fleet[$i]->fle_id)
                    ->where('ef.acc_id', '=', $user->acc_id)
                    ->groupBy('v.fle_id', 'f.fle_nam')
                    ->orderBy('sumatoria', 'desc')
                    ->get();

                if ($x_convert == 2) {//si viene 2 convierto de litros a galones
                    foreach ($select as $sel) {
                        $sel->sumatoria = $sel->sumatoria * 0.26417;
                        $sel->sumatoria = round($sel->sumatoria, 4);
                    }
                }

                //si no existe nada en la flota, guardo 0
                if (count($select) < 1) {
                    $select = [
                        "fle_nam" => $fleet[$i]->fle_nam,
                        "sumatoria" => 0
                    ];
                    array_push($totalsExp, $select);
                } else {
                    foreach ($select as $ope) {
                        $select = [
                            "fle_nam" => $ope->fle_nam,
                            "sumatoria" => abs($ope->sumatoria)
                        ];
                        array_push($totalsExp, $select);
                    }

                }
            }

            //si consigue algo devuelve los datos
            return response()->json($totalsExp, 200);
        }else{
            $totalsExp = array();
            //si viene mes
            for ($i = 0; $i <count($fleet); $i++) {
                $select = DB::table('expenses_fuels as ef')
                    ->select('f.fle_nam', DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
                    ->leftJoin('detail_expenses_fuels as def', 'def.exp_id', 'ef.exp_id')
                    ->leftJoin('assignments as a', 'a.ass_id', 'ef.ass_id')
                    ->leftJoin('vehicles as v', 'v.veh_pla', 'a.veh_pla')
                    ->leftJoin('fleets as f', 'f.fle_id', 'v.fle_id')
                    ->whereYear('ef.created_at', $explode1[0])
                    ->whereMonth('ef.created_at', $explode1[1])
                    ->where('ef.exp_act', '=', true)
                    ->where('f.fle_id', '=', $fleet[$i]->fle_id)
                    ->where('ef.acc_id', '=', $user->acc_id)
                    ->groupBy('v.fle_id', 'f.fle_nam')
                    ->orderBy('sumatoria', 'desc')
                    ->get();

                if($x_convert == 2){//si viene 2 convierto de litros a galones
                    foreach ($select as $sel){
                        $sel->sumatoria = $sel->sumatoria * 0.26417;
                        $sel->sumatoria = round($sel->sumatoria, 4);
                    }
                }

                //si no existe nada en la flota, guardo 0
                if (count($select) < 1) {
                    $select = [
                        "fle_nam" => $fleet[$i]->fle_nam,
                        "sumatoria" => 0
                    ];
                    array_push($totalsExp, $select);
                } else {
                    foreach ($select as $ope) {
                        $select = [
                            "fle_nam" => $ope->fle_nam,
                            "sumatoria" => abs($ope->sumatoria)
                        ];
                        array_push($totalsExp, $select);
                    }

                }
            }

            //si consigue algo devuelve los datos
            return response()->json($totalsExp, 200);
        }
    }

    /**
     * grafico de barras con comparacion de consumo por año
     * @param $x_date1 = valor del primer dato
     * @param $x_date2 = valor del segundo dato
     * @param $x_plate valor de la placa, si viene null filtro por todos los vehiculos
     * @return json con los datos de cada tiempo a comparar
     */
    public function graphMatchConsumption($x_date1, $x_date2, $x_plate)
    {
        $totals = array();
        $user =  $user = $this->currentUSer();
        if(!Vehicle::find($x_plate) && $x_plate){
            return  response()->json(["message" => "El Vehiculo por el que esta filtrando no existe"], 500)
                ->setStatusCode(500, 'El Vehiculo por el que esta filtrando no existe');
        }
        $explode1 = explode('-',$x_date1); //explode para saber si viene año-mes o solo año ejem 2018-01 ó solo 2018
        if(count($explode1)!=2) { //solo viene año
            //consulto el 1 parametro de matching

            $select = DB::table('expenses_fuels as ef')
                ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
                ->join('detail_expenses_fuels as def','def.exp_id','ef.exp_id')
                ->join('assignments as a', 'a.ass_id', 'ef.ass_id')
                ->whereYear('ef.created_at', $x_date1)
                ->where('ef.exp_act', '=', true)
                ->if($x_plate, 'a.veh_pla', '=', $x_plate) //si viene placa filtro por placa sino por todos
                ->where('ef.acc_id', '=', $user->acc_id)
                ->get();

            //recorro los datos para sacar la sumatoria
            foreach ($select as $ope) {
                //creo el array
                $select = [
                    "date" => $x_date1,
                    "sumatoria" => $ope->sumatoria?:"0"
                ];
                //despues pusheo al array final
                array_push($totals, $select);
            }

            //consulto el 2 parametro de matching
            $select = DB::table('expenses_fuels as ef')
                ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
                ->join('detail_expenses_fuels as def','def.exp_id','ef.exp_id')
                ->join('assignments as a', 'a.ass_id', 'ef.ass_id')
                ->whereYear('ef.created_at', $x_date2)
                ->where('ef.exp_act', '=', true)
                ->if($x_plate, 'a.veh_pla', '=', $x_plate)  //si viene placa filtro por placa sino por todos
                ->where('ef.acc_id', '=', $user->acc_id)
                ->get();

            //recorro los datos para sacar la sumatoria
            foreach ($select as $ope) {
                //creo el array
                $select = [
                    "date" => $x_date2,
                    "sumatoria" => $ope->sumatoria?:"0"
                ];
                //despues pusheo al array final
                array_push($totals, $select);
            }

            //retorno el array
            return response()->json($totals, 200);
        }else{ //viene mes

            $explode2 = explode('-',$x_date2); //hago el explode del segundo dato, ya el primero lo hice arriba
            $totals = array();

            //consulto el 1 parametro de matching
            $select = DB::table('expenses_fuels as ef')
                ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
                ->join('detail_expenses_fuels as def','def.exp_id','ef.exp_id')
                ->join('assignments as a', 'a.ass_id', 'ef.ass_id')
                ->whereYear('ef.created_at', $explode1[0])
                ->whereMonth('ef.created_at', $explode1[1])
                ->where('ef.exp_act', '=', true)
                ->if($x_plate, 'a.veh_pla', '=', $x_plate)  //si viene placa filtro por placa sino por todos
                ->where('ef.acc_id', '=', $user->acc_id)
                ->get();

            //recorro los datos para sacar la sumatoria
            foreach ($select as $ope) {
                //creo el array
                $select = [
                    "date" => $x_date1,
                    "sumatoria" => $ope->sumatoria?:"0"
                ];
                //despues pusheo al array final
                array_push($totals, $select);
            }

            //consulto el 2 parametro de matching
            $select = DB::table('expenses_fuels as ef')
                ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'))
                ->join('detail_expenses_fuels as def','def.exp_id','ef.exp_id')
                ->join('assignments as a', 'a.ass_id', 'ef.ass_id')
                ->whereYear('ef.created_at', $explode2[0])
                ->whereMonth('ef.created_at', $explode2[1])
                ->where('ef.exp_act', '=', true)
                ->if($x_plate, 'a.veh_pla', '=', $x_plate)  //si viene placa filtro por placa sino por todos
                ->where('ef.acc_id', '=', $user->acc_id)
                ->get();

            //recorro los datos para sacar la sumatoria
            foreach ($select as $ope) {
                //creo el array
                $select = [
                    "date" => $x_date2,
                    "sumatoria" => $ope->sumatoria?:"0"
                ];
                //despues pusheo al array final
                array_push($totals, $select);
            }

            return response()->json($totals, 200);
        }
    }

    /**
     * segundo grafico de barras con comparacion de consumo por año y mes
     * @param $x_date1 = valor del primer dato
     * @param $x_date2 = valor del segundo dato
     * @param $x_plate valor de la placa, si viene null filtro por todos los vehiculos
     * @return json con los datos de cada tiempo a comparar
     */
    public function graphMatchTwoConsumption($x_date1, $x_date2, $x_plate)
    {
        $totals = array();
        $totals2 = array();
        $month = 12;
        $user =  $user = $this->currentUSer();
        if(!Vehicle::find($x_plate) && $x_plate){
            return  response()->json(["message" => "El Vehiculo por el que esta filtrando no existe"], 500)
                ->setStatusCode(500, 'El Vehiculo por el que esta filtrando no existe');
        }
        $explode1 = explode('-',$x_date1); //explode para saber si viene año-mes o solo año ejem 2018-01 ó solo 2018
        if(count($explode1)!=2) { //solo viene año
            //consulto el 1 parametro de matching
            for ($i = 0; $i <$month; $i++) {


                $select = DB::table('expenses_fuels as ef')
                    ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'), DB::raw("EXTRACT(MONTH FROM ef.created_at) as month"))
                    ->join('detail_expenses_fuels as def', 'def.exp_id', 'ef.exp_id')
                    ->join('assignments as a', 'a.ass_id', 'ef.ass_id')
                    ->whereYear('ef.created_at', $x_date1)
                    ->whereMonth('ef.created_at', $i+1)
                    ->where('ef.exp_act', '=', true)
                    ->if($x_plate, 'a.veh_pla', '=', $x_plate)  //si viene placa filtro por placa sino por todos
                    ->where('ef.acc_id', '=', $user->acc_id)
                    ->groupBy('month')
                    ->get();

                //si no existe nada en el mes, guardo 0
                if (count($select) < 1) {
                    $select = [
                        "date" => "$x_date1-".$i,
                        "sumatoria" =>"0"
                    ];
                    //despues pusheo al array final
                    array_push($totals, $select);
                }else {
                    //recorro los datos para sacar la sumatoria
                    foreach ($select as $ope) {
                        //creo el array
                        $select = [
                            "date" => "$x_date1-".$i,
                            "sumatoria" => $ope->sumatoria ?: "0"
                        ];
                        //despues pusheo al array final
                        array_push($totals, $select);
                    }
                }

                //consulto el 2 parametro de matching
                $select1 = DB::table('expenses_fuels as ef')
                    ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'), DB::raw("EXTRACT(MONTH FROM ef.created_at) as month"))
                    ->join('detail_expenses_fuels as def', 'def.exp_id', 'ef.exp_id')
                    ->join('assignments as a', 'a.ass_id', 'ef.ass_id')
                    ->whereYear('ef.created_at', $x_date2)
                    ->whereMonth('ef.created_at', $i+1)
                    ->where('ef.exp_act', '=', true)
                    ->if($x_plate, 'a.veh_pla', '=', $x_plate)  //si viene placa filtro por placa sino por todos
                    ->where('ef.acc_id', '=', $user->acc_id)
                    ->groupBy('month')
                    ->get();

                //si no existe nada en el mes, guardo 0
                if (count($select1) < 1) {
                    $select1 = [
                        "date" => "$x_date2-".$i,
                        "sumatoria" =>"0"
                    ];
                    //despues pusheo al array final
                    array_push($totals2, $select1);
                }else {
                    //recorro los datos para sacar la sumatoria
                    foreach ($select1 as $ope) {
                        //creo el array
                        $select1 = [
                            "date" => "$x_date2-".$i,
                            "sumatoria" => $ope->sumatoria ?: "0"
                        ];
                        //despues pusheo al array final
                        array_push($totals2, $select1);
                    }
                }
            }

            //retorno el array
            return response()->json([$totals,$totals2], 200);
        }else{ //viene mes

            $explode2 = explode('-',$x_date2); //hago el explode del segundo dato, ya el primero lo hice arriba
            $day = date("t",mktime(0,0,0,$explode1[1],1,$explode1[0]));  // saco la cantidad de dias del mes
            for ($i = 1; $i <=$day; $i++) {
                $created_at1 = "$x_date1-$i";

                //consulto el 1 parametro de matching
                $select = DB::table('expenses_fuels as ef')
                    ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'), DB::raw('EXTRACT(DAY FROM ef.created_at)'))
                    ->join('detail_expenses_fuels as def', 'def.exp_id', 'ef.exp_id')
                    ->join('assignments as a', 'a.ass_id', 'ef.ass_id')
                    ->whereDate('ef.created_at', $created_at1)
                    ->where('ef.exp_act', '=', true)
                    ->if($x_plate, 'a.veh_pla', '=', $x_plate)  //si viene placa filtro por placa sino por todos
                    ->where('ef.acc_id', '=', $user->acc_id)
                    ->groupBy(DB::raw('EXTRACT(DAY FROM ef.created_at)'))
                    ->get();

                //si no existe nada en el mes, guardo 0
                if (count($select) < 1) {
                    $select = [
                        "date" => $created_at1,
                        "sumatoria" => "0"
                    ];
                    //despues pusheo al array final
                    array_push($totals, $select);
                } else {
                    //recorro los datos para sacar la sumatoria
                    foreach ($select as $ope) {
                        //creo el array
                        $select = [
                            "date" => $created_at1,
                            "sumatoria" => $ope->sumatoria ?: "0"
                        ];
                        //despues pusheo al array final
                        array_push($totals, $select);
                    }
                }
            }
            $day2 = date("t",mktime(0,0,0,$explode2[1],1,$explode2[0]));  // saco la cantidad de dias del mes
            for ($i = 1; $i <=$day2; $i++) {
                $created_at = "$x_date2-$i";

                //consulto el 2 parametro de matching
                $select1 = DB::table('expenses_fuels as ef')
                    ->select(DB::raw('cast(format_numbers(SUM(def.dex_qua)) as numeric) as sumatoria'), DB::raw('EXTRACT(DAY FROM ef.created_at)'))
                    ->join('detail_expenses_fuels as def', 'def.exp_id', 'ef.exp_id')
                    ->join('assignments as a', 'a.ass_id', 'ef.ass_id')
                    ->whereDate('ef.created_at', $created_at)
                    ->where('ef.exp_act', '=', true)
                    ->if($x_plate, 'a.veh_pla', '=', $x_plate)  //si viene placa filtro por placa sino por todos
                    ->where('ef.acc_id', '=', $user->acc_id)
                    ->groupBy(DB::raw('EXTRACT(DAY FROM ef.created_at)'))
                    ->get();

                //si no existe nada en el mes, guardo 0
                if (count($select1) < 1) {
                    $select1 = [
                        "date" => $created_at,
                        "sumatoria" => "0"
                    ];
                    //despues pusheo al array final
                    array_push($totals2, $select1);
                } else {
                    //recorro los datos para sacar la sumatoria
                    foreach ($select1 as $ope) {
                        //creo el array
                        $select1 = [
                            "date" => $created_at,
                            "sumatoria" => $ope->sumatoria ?: "0"
                        ];
                        //despues pusheo al array final
                        array_push($totals2, $select1);
                    }
                }
            }
            return response()->json([$totals,$totals2], 200);
        }
    }

}

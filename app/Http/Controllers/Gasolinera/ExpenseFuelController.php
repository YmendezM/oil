<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\ExpenseFuelService;
use App\Models\Gasolinera\Assignment;
use App\Models\Gasolinera\DetailExpenseFuel;
use App\Models\Gasolinera\ExpenseFuel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseFuelController extends TatucoController
{
    public function __construct()
    {
        $this->service = new ExpenseFuelService();
        $this->namePrimaryKey = 'exp_id';//llave primaria
        $this->status = 'exp_act';//campo de activo o eliminado
    }

    /**
     * @return index de ExpenseFuelService
     */
    public function index(Request $request)
    {
      return $this->service->index($request);
    }

    /**
     * @param Request $request
     * @return store de ExpenseFuelService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de ExpenseFuelService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }

    public function destroy($x_pk)
    {
        return $this->service->destroy($this->namePrimaryKey, $x_pk, $this->status);
    }

    /**
     * @return findForPlate de ExpenseFuelService
     */
    public function findForPlate()
    {
        return $this->service->findForPlate();
    }

    /**
     * @return findVehicle de ExpenseFuelService
     */
    public function findVehicle()
    {
        return $this->service->findVehicle();
    }

    /**
     * @return findDriver de ExpenseFuelService
     */
    public function findDriver()
    {
        return $this->service->findDriver();
    }

    /**
     * @param $x_plate = placa del vehicle
     * @return assignmentsForPlate de ExpenseFuelService
     */
    public function assignmentsForPlate($x_plate)
    {
        return $this->service->assignmentsForPlate($x_plate);
    }

    /**
     * @param $x_plate = placa del vehicle
     * @return assignmentsVehicle de ExpenseFuelService
     */
    public function assignmentsVehicle($x_plate)
    {
        return $this->service->assignmentsVehicle($x_plate);
    }

    /**
     * @param $x_dni = dni del Driver
     * @return assignmentsDriver de ExpenseFuelService
     */
    public function assignmentsDriver($x_dni)
    {
        //llama a userService
        return $this->service->assignmentsDriver($x_dni);
    }

    /**
     * @return returnIdOperation de ExpenseFuelService
     */
    public function returnIdOperation()
    {
        //llama a userService
        return $this->service->returnIdOperation();
    }
/*
    public function import()
    {
        Excel::load('public/mayo.csv', function ($reader) {
            $i = 0;
            $ID_d = 3083;
            $ID_c = 3083;
            foreach ($reader->get() as $book) {
                    $ID_d = $ID_d+1;
                    $ID_c = $ID_c+1;
                    $i = $i+1;
               // $book->fecha = explode("/", $book->fecha);
                //$book->fecha = $book->fecha[1].'/'.$book->fecha[0].'/'.$book->fecha[2];
                echo $i;
                $quantity = ($book->galones * 3.78541178)/1;
                $value = Assignment::where('veh_pla', $book->placa)->first();
                $operation = new ExpenseFuel();
                $operation->exp_id = $ID_d;
                $operation->created_at = $book->fecha;
                $operation->use_nic = 'sysadmin';
                $operation->ass_id = $value->ass_id;
                $operation->acc_id = 1;
                $operation->save();


                //guardo el detail_expense_fuel
                $detail = new DetailExpenseFuel();
                $detail->dex_id = $ID_c;
                $detail->created_at = $book->fecha;
                $detail->dex_qua = $quantity;
                $detail->dex_hor = $book->horometro;
                $detail->exp_id = $ID_d;
                $detail->tfu_id = 2;
                $detail->fue_id = 2;
                $detail->acc_id = 1;
                $detail->save();

            }
        });
    }
*/
}

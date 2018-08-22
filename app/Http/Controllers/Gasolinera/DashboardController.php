<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\DashboardService;
use Illuminate\Http\Request;
class DashboardController extends TatucoController
{
    public function __construct()
    {
        $this->service = new DashboardService();
    }

    /**
     * @return topdriver dashboardService
     */
    public function topDriver(){
        return $this->service->topDriver();

    }

    /**
     * @return topvehicle dashboardService
     */
    public function topVehicle(){
        return $this->service->topVehicle();
    }

    /**
     * @param $x_date = valor de la fecha
     * @return totalsDashboard de dashboardService
     */
    public function totalsDashboard($x_date)
    {
        return $this->service->totalsDashboard($x_date);
    }

    /**
     * @param $x_date = valor de la fecha
     * @return graphTotalOperationDashboard de dashboardService
     */
    public function graphTotalOperationDashboard($x_date)
    {
        return $this->service->graphTotalOperationDashboard($x_date);
    }

    /**
     * @param $x_date = valor de la fecha
     * @return graphTotalExpensesDashboard de dashboardService
     */
    public function graphTotalExpensesDashboard($x_date)
    {
        return $this->service->graphTotalExpensesDashboard($x_date);
    }

    /**
     * @param $x_date = valor de la fecha
     * @param $x_convert = bandera para convertir, si viene 1 lo deja en litros, si viene 2 convierte litros a galones
     * @return graphVehicleConsumption de dashboardService
     */
    public function graphVehicleConsumption($x_date, $x_convert, $x_fleet = null)
    {
        return $this->service->graphVehicleConsumption($x_date, $x_convert, $x_fleet);
    }

    /**
     * @param $x_date = valor de la fecha
     * @param $x_convert = bandera para convertir, si viene 1 lo deja en litros, si viene 2 convierte litros a galones
     * @return graphFleetConsumption de dashboardService
     */
    public function graphFleetConsumption($x_date, $x_convert)
    {
        return $this->service->graphFleetConsumption($x_date, $x_convert);
    }

    /**
     * @param $x_date1 = valor del primer dato
     * @param $x_date2 valor del segundo dato
     * @param $x_plate valor de la placa, si viene null filtro por todos los vehiculos
     * @return graphMatchConsumption de dashboardService
     */
    public function graphMatchConsumption($x_date1, $x_date2, $x_plate=null)
    {
        return $this->service->graphMatchConsumption($x_date1, $x_date2, $x_plate);
    }

    /**
     * @param $x_date1 = valor del primer dato
     * @param $x_date2 valor del segundo dato
     * @param $x_plate valor de la placa, si viene null filtro por todos los vehiculos
     * @return graphMatchTwoConsumption de dashboardService
     */
    public function graphMatchTwoConsumption($x_date1, $x_date2, $x_plate=null)
    {
        return $this->service->graphMatchTwoConsumption($x_date1, $x_date2, $x_plate);
    }

}

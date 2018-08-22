<?php

namespace App\Http\Controllers\Tatuco;

use App\Models\Gasolinera\Account;
use App\Models\Gasolinera\BrandVehicle;
use App\Models\Gasolinera\City;
use App\Models\Gasolinera\Countrie;
use App\Models\Gasolinera\Driver;
use App\Models\Gasolinera\ExpenseFuel;
use App\Models\Gasolinera\Fleet;
use App\Models\Gasolinera\Fuel;
use App\Models\Gasolinera\ModelVehicle;
use App\Models\Gasolinera\Provider;
use App\Models\Gasolinera\RegionalConfiguration;
use App\Models\Gasolinera\Station;
use App\Models\Gasolinera\Status;
use App\Models\Gasolinera\TypeFuel;
use App\Models\Gasolinera\Vehicle;
use App\Models\Tatuco\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Services\Tatuco\ReportService;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    public $service;
    public $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * reporte de users**
     * @param Request $request
     * @return report de reportService
     */
    public function users(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'DNI' => 'use_dni',
            'Nombres' => 'use_nam',
            'Apellidos' => 'use_lna',
            'Email' => 'email',
            'Nombre de Usuario' => 'use_nic'
        ];
        //setea el nombre del modelo
        $model= new User();
        //setea el nombre plural
        $namePlural='Usuarios';
        $title='Reporte de Usuarios';
        $status = 'use_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de accounts
     * @param Request $request
     * @return report de reportService
     */
    public function accounts(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Nombre' => 'acc_nom',
            'RUC' => 'acc_ruc',
            'Descripcion' => 'acc_des',
            'Direccion' => 'acc_dir',
            'Correo' => 'acc_mai',
            'Telefono' => 'acc_pho',
            'Web' => 'acc_web'
        ];
        //setea el nombre del modelo
        $model= new Account();
        //setea el nombre plural
        $namePlural='Empresas';
        $title='Reporte de Empresas';
        $status = 'acc_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de status
     * @param Request $request
     * @return report de reportService
     */
    public function status(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Nombre' => 'sta_des',
            'Entidad donde se usa' => 'sta_tab'
        ];
        //setea el nombre del modelo
        $model= new Status();
        //setea el nombre plural
        $namePlural='Status';
        $title='Reporte de Status';
        $status = 'sta_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de drivers
     * @param Request $request
     * @return report de reportService
     */
    public function drivers(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'DNI' => 'dri_dni',
            'Nombres' => 'dri_nam',
            'Apellidos' => 'dri_lna',
            'Licencia' => 'dri_lic',
            'Telefono' => 'dri_pho',
            'Email' => 'dri_mai'
        ];
        //setea el nombre del modelo
        $model= new Driver();
        //setea el nombre plural
        $namePlural='Conductores';
        $title='Reporte de Conductores';
        $status = 'dri_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de brandsVehicles
     * @param Request $request
     * @return report de reportService
     */
    public function brandsVehicles(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Nombre de la Marca' => 'bra_des'
        ];
        //setea el nombre del modelo
        $model= new BrandVehicle();
        //setea el nombre plural
        $namePlural='Marcas de Vehiculos';
        $title='Reporte de Marcas de Vehiculos';
        $status = 'bra_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de modelsVehicles
     * @param Request $request
     * @return report de reportService
     */
    public function modelsVehicles(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Nombre del Modelo' => 'mod_des'
        ];
        //setea el nombre del modelo
        $model= new ModelVehicle();
        //setea el nombre plural
        $namePlural='Modelos de Vehiculos';
        $title='Reporte de Modelos de Vehiculos';
        $status = 'mod_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de typesVehicles
     * @param Request $request
     * @return report de reportService
     */
    public function typesVehicles(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Nombre del Tipo de Vehiculo' => 'tve_des'
        ];
        //setea el nombre del modelo
        $model=TypeVehicle();
        //setea el nombre plural
        $namePlural='Tipos de Vehiculos';
        $title='Reporte de Tipos de Vehiculos';
        $status = 'tve_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }


    /**
     * reporte de fleets
     * @param Request $request
     * @return report de reportService
     */
    public function fleets(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Nombre de la Flota' => 'fle_des'
        ];
        //setea el nombre del modelo
        $model= new Fleet();
        //setea el nombre plural
        $namePlural='Flotas';
        $title='Reporte de Flotas';
        $status = 'fle_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }


    /**
     * reporte de vehicles
     * @param Request $request
     * @return report de reportService
     */
    public function vehicles(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Placa' => 'veh_pla',
            'Limite de Consumo' => 'veh_com',
            'Tipo de Vehiculo' => 'tve_id',
            'Modelo del Vehiculo' => 'mod_id',
            'Flota del Vehiculo' => 'fle_id',
            'Estado de Asignacion' => 'sta_id'
        ];
        //setea el nombre del modelo
        $model= new Vehicle();
        //setea el nombre plural
        $namePlural='Vehiculos';
        $title='Reporte de Vehiculos';
        $status = 'veh_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de fuels
     * @param Request $request
     * @return report de reportService
     */
    public function fuels(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Octanaje' => 'fue_oct',
            'Cantidad Actual' => 'fue_qua',
        ];
        //setea el nombre del modelo
        $model= new Fuel();
        //setea el nombre plural
        $namePlural='Combustibles';
        $title='Reporte de Combustibles';
        $status = 'fue_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de typesFuels
     * @param Request $request
     * @return report de reportService
     */
    public function typesFuels(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Tipo de Combustible' => 'tfu_des',
        ];
        //setea el nombre del modelo
        $model= new TypeFuel();
        //setea el nombre plural
        $namePlural='Tipos de combustible';
        $title='Reporte de Tipos de Combustible';
        $status = 'tfu_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de regionalsConfigurations
     * @param Request $request
     * @return report de reportService
     */
    public function regionalsConfigurations(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Moneda Utilizada' => 'rco_mon',
            'Unidad de Medida de Volumen' => 'rco_umv',
            'Unidad de Medida de Peso' => 'rco_ump',
            'Unidad de Medida de Longitud' => 'rco_uml',
        ];
        //setea el nombre del modelo
        $model= new RegionalConfiguration();
        //setea el nombre plural
        $namePlural='Configuracion Regional';
        $title='Reporte de Configuracion Regional';
        $status = 'rco_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de countries
     * @param Request $request
     * @return report de reportService
     */
    public function countries(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Pais' => 'cou_des',
            'Uso Horario' => 'cou_uho',
        ];
        //setea el nombre del modelo
        $model= new Countrie();
        //setea el nombre plural
        $namePlural='Paises';
        $title='Reporte de Paises';
        $status = 'cou_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de cities
     * @param Request $request
     * @return report de reportService
     */
    public function cities(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Pais' => 'cit_des',
        ];
        //setea el nombre del modelo
        $model= new City();
        //setea el nombre plural
        $namePlural='Ciudades';
        $title='Reporte de Ciudades';
        $status = 'cit_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de providers
     * @param Request $request
     * @return report de reportService
     */
    public function providers(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'DNI' => 'pve_dni',
            'Nombres' => 'pve_nam',
            'Apellidos' => 'pve_lna',
            'Telefono' => 'pve_pho',
            'Email' => 'pve_mai'
        ];
        //setea el nombre del modelo
        $model= new Provider();
        //setea el nombre plural
        $namePlural='Proveedores';
        $title='Reporte de Proveedores';
        $status = 'pve_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }

    /**
     * reporte de stations
     * @param Request $request
     * @return report de reportService
     */
    public function stations(Request $request)
    {
        //setea las nombres con las columnas en la bd
        $columns = [
            'Estacion de Servicio' => 'sts_nam',
            'Direccion' => 'sts_dir',
            'Cantidad Actual' => 'sts_qut',
            'Telefono' => 'sts_pho',
            'Email' => 'sts_mai'
        ];
        //setea el nombre del modelo
        $model= new Station();
        //setea el nombre plural
        $namePlural='Estaciones de Servicio';
        $title='Reporte de Estaciones de Servicio';
        $status = 'sts_act';
        $acc = 'acc_id';
        $created = 'created_at';

        return $this->reportService->report($request,$model, $namePlural, $columns, $title, $status, $acc, $created);
    }


    /**
     * reporte de expensesFuel
     * @param Request $request
     * @return report de reportService
     */
    public function expensesFuel(Request $request)
    {
        //Parametros a pasar al service
        //setea las nombres con las columnas en la bd
        $columns = [
            'Op' =>'exp_id',
            'Id' =>'veh_id',
            'Placa' => 'veh_pla',
            'Conductor' => 'name',
            'Combustible' => 'fue_oct',
            'Cantidad' => 'dex_qua',
            'Horometro' => 'dex_hor',
            'Usuario' => 'use_nic',
            'Fecha/Hora' => 'created_at',
        ];

        $select = ExpenseFuel::from('expenses_fuels as ef')
            ->select("ef.exp_id","v.veh_pla", "v.veh_id", "d.dri_nam as name",
                "f.fue_oct",DB::raw("cast(format_numbers(def.dex_qua) as numeric) as dex_qua"),
                'def.dex_hor', "ef.use_nic","ef.created_at", "ef.exp_act")
            ->leftJoin("detail_expenses_fuels as def", "def.exp_id", "ef.exp_id")
            ->leftJoin("assignments as a", "a.ass_id", "ef.ass_id")
            ->leftJoin("vehicles as v", "v.veh_pla", "a.veh_pla")
            ->leftJoin("drivers as d", "d.dri_dni", "a.dri_dni")
            ->leftJoin("fuels as f", "f.fue_id", "def.fue_id")
            ->orderBy('ef.created_at', 'desc');
        //setea el nombre del modelo
        $model= new ExpenseFuel();
        //setea el nombre plural
        $namePlural='Operacioness';
        $title='Reporte de Operaciones';
        $status = 'ef.exp_act';
        $acc = 'ef.acc_id';
        $created = 'ef.created_at';

        $hoy = Carbon::now(); //instancio fecha actual
        $id = $request->get('id');  //saco del request los datos que necesito
        if($id ==1){
            $fromDate = $hoy->subMonth(3)->format('Y-m-d'); //fecha de inicio
            $toDate =$hoy->addMonth(3)->addDay(1)->format('Y-m-d'); //fecha fin
        }else{
            $fromDate = $request->get('from_date');//fecha de inicio
            $toDate = $request->get('to_date');//fecha fin
        }

        return $this->reportService->report($request, $model, $fromDate, $toDate, $status, $acc
            , $created, $namePlural, $columns, $select, $title);
    }


}
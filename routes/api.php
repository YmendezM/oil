<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//ruta para identificar si el front tiene conexion con la api
Route::get('/test', function (){
    return response()->json([
        "conexion"=> 1
    ], 200);
});


Route::post('/login', ['uses' => 'Tatuco\AuthController@login', 'as' => 'login']);
Route::post('/logout', ['middleware' => ['jwt.auth'], 'uses' => 'Tatuco\AuthController@logout', 'as' => 'logout']);
Route::get('/validate', ['middleware' => ['jwt.auth'], 'uses' => 'Tatuco\AuthController@validate', 'as' => 'validate']);
Route::get('/admin', function()
{
    echo "eres sysadmin!";
})->middleware('role:sysadmin');

Route::get('/permiso', function()
{
    echo "tienes permiso!";
})->middleware('permission:run.backup');


/**
 * grupo de rutas controladas por jwt (requieren token)
 */
Route::group([
    'middleware' => ['jwt.auth']
    ], function (){
    /**
     * grupo de rutas controladas por el rol sysadmin
     */
        //rutas a la carpeta tatuco
        Route::resource('users', 'Tatuco\UserController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('roles', 'Tatuco\RoleController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('permissions', 'Tatuco\PermissionController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('permissions/roles', 'Tatuco\PermissionRoleController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::get('/backup', 'Tatuco\TatucoController@backup')->middleware('permission:run.backup');
        Route::post('users/role', 'Tatuco\UserController@assignedRole');
        Route::get('users/role/{user}/{role}', 'Tatuco\UserController@revokeRole');
        Route::post('roles/permission', 'Tatuco\RoleController@assignedPermission');
        Route::get('roles/permission/{role}/{permission}', 'Tatuco\RoleController@revokePermission');
        Route::get('roles/permission/{role}/{permission}', 'Tatuco\RoleController@revokePermission');


        /*
         * rutas a la carpeta gasolinera
         */
        Route::resource('accounts', 'Gasolinera\AccountController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('status', 'Gasolinera\StatusController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('drivers', 'Gasolinera\DriverController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('brands/vehicles', 'Gasolinera\BrandVehicleController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('models/vehicles', 'Gasolinera\ModelVehicleController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('fleets', 'Gasolinera\FleetController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('vehicles', 'Gasolinera\VehicleController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('fuels', 'Gasolinera\FuelController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('regionals/configurations', 'Gasolinera\RegionalConfigurationController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('countries', 'Gasolinera\CountrieController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('cities', 'Gasolinera\CityController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('providers', 'Gasolinera\ProviderController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('stations', 'Gasolinera\StationController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('expenses', 'Gasolinera\ExpenseFuelController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('assignments', 'Gasolinera\AssignmentController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('exp/fuels', 'Gasolinera\ExpenseFuelController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('notifications', 'Gasolinera\NotificationController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('automatics/emails', 'Gasolinera\AutomaticMailController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('audits', 'Gasolinera\AuditController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
        Route::resource('maintenances', 'Mantenimiento\MaintenanceController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

        /*
        * rutas sueltas
        */
        Route::get('/find/for/vehicles', 'Gasolinera\ExpenseFuelController@findForPlate');
        Route::get('/find/vehicles', 'Gasolinera\ExpenseFuelController@findVehicle');
        Route::get('/find/drivers', 'Gasolinera\ExpenseFuelController@findDriver');
        Route::get('/assignments/for/plate/{plate}', 'Gasolinera\ExpenseFuelController@assignmentsForPlate');
        Route::get('/assignments/vehicles/{plate}', 'Gasolinera\ExpenseFuelController@assignmentsVehicle');
        Route::get('/assignments/drivers/{dni}', 'Gasolinera\ExpenseFuelController@assignmentsDriver');
        Route::get('/return/id', 'Gasolinera\ExpenseFuelController@returnIdOperation');
        Route::get('/alerts/drivers', 'Gasolinera\NotificationController@alertDriver');
        Route::get('/alerts/vehicles', 'Gasolinera\NotificationController@alertVehicle');
        Route::get('/import', 'Gasolinera\ExpenseFuelController@import');
        Route::get('/test/smtp/{smtp}/{port}/{from}/{pass}', 'Gasolinera\AutomaticMailController@testSmtp');
        Route::get('/consult/gps/{plate}/{flag}', 'Mantenimiento\MaintenanceController@consultGps');
        Route::get('test/send', 'Gasolinera\AutomaticMailController@consultSendMail');
        Route::get('status/maintenances/{plate}', 'Mantenimiento\MaintenanceController@statusMaintenance');

        /*
        * rutas del dashboard
        */
        Route::get('/top/vehicles', 'Gasolinera\DashboardController@topVehicle');
        Route::get('/top/drivers', 'Gasolinera\DashboardController@topDriver');
        Route::get('/totals/dashboard/{date}/', 'Gasolinera\DashboardController@totalsDashboard');
        Route::get('/graph/totals/operation/dashboard/{date}/', 'Gasolinera\DashboardController@graphTotalOperationDashboard');
        Route::get('/graph/totals/expenses/dashboard/{date}', 'Gasolinera\DashboardController@graphTotalExpensesDashboard');
        Route::get('/graph/totals/vehicles/expenses/dashboard/{date}/{convert}/{idFleet?}', 'Gasolinera\DashboardController@graphVehicleConsumption');
        Route::get('/graph/totals/fleets/expenses/dashboard/{date}/{convert}/', 'Gasolinera\DashboardController@graphFleetConsumption');
        Route::get('/graph/totals/match/expenses/dashboard/{date}/{date2}/{plate?}', 'Gasolinera\DashboardController@graphMatchConsumption');
        Route::get('/graph/totals/match/two/expenses/dashboard/{date}/{date2}/{plate?}', 'Gasolinera\DashboardController@graphMatchTwoConsumption');

         /*
          *rutas con el prefijo selects
         */
        Route::group(['prefix' => 'selects'], function () {
            Route::get('/roles', 'Tatuco\RoleController@selectRoles');
            Route::get('/users/status', 'Gasolinera\StatusController@statusUser');
            Route::get('/vehicles/status', 'Gasolinera\StatusController@statusVehicle');
            Route::get('/drivers/status', 'Gasolinera\StatusController@statusDriver');
            Route::get('/brands', 'Gasolinera\BrandVehicleController@selectBrands');
            Route::get('/models/{idBrand}', 'Gasolinera\ModelVehicleController@selectModels');
            Route::get('/all/models', 'Gasolinera\ModelVehicleController@selectModelsAll');
            Route::get('/fleets', 'Gasolinera\FleetController@selectFleets');
            Route::get('/types/vehicles', 'Gasolinera\TypeVehicleController@selectTypes');
            Route::get('/types/vehicles', 'Gasolinera\TypeVehicleController@selectTypes');
            Route::get('/vehicles', 'Gasolinera\VehicleController@selectVehicle');
            Route::get('/types/fuels', 'Gasolinera\TypeFuelController@selectTypes');
            Route::get('/fuels/{idFuel}', 'Gasolinera\FuelController@selectFuels');

         });//cierre de rutas selects

        /**
         * rutas con el prefijo types
         */
        Route::group(['prefix' => 'types'], function () {
            Route::resource('/vehicles', 'Gasolinera\TypeVehicleController', ['only' => ['index', 'store', 'update', 'destroy', 'show','create']]);
            Route::resource('/fuels', 'Gasolinera\TypeFuelController', ['only' => ['index', 'store', 'update', 'destroy', 'show','create']]);
        });//cierre de rutas types


        /**
         * rutas con el prefijo reports
         */
        Route::group(['prefix' => 'reports'], function () {
            Route::get('users','Tatuco\ReportController@Users');
            Route::get('accounts','Tatuco\ReportController@accounts');
            Route::get('status','Tatuco\ReportController@status');
            Route::get('drivers','Tatuco\ReportController@drivers');
            Route::get('brands/vehicles','Tatuco\ReportController@brandsVehicles');
            Route::get('models/vehicles','Tatuco\ReportController@modelsVehicles');
            Route::get('types/vehicles','Tatuco\ReportController@typesVehicles');
            Route::get('fleets','Tatuco\ReportController@fleets');
            Route::get('vehicles','Tatuco\ReportController@vehicles');
            Route::get('fuels','Tatuco\ReportController@fuels');
            Route::get('types/fuels','Tatuco\ReportController@typesFuels');
            Route::get('regionals/configurations','Tatuco\ReportController@regionalsConfigurations');
            Route::get('countries','Tatuco\ReportController@countries');
            Route::get('cities','Tatuco\ReportController@cities');
            Route::get('providers','Tatuco\ReportController@providers');
            Route::get('stations','Tatuco\ReportController@stations');
            Route::get('stations','Tatuco\ReportController@stations');
            Route::get('expenses/fuels','Tatuco\ReportController@expensesFuel');
        });//cierre de rutas de reporte




});//cierre de rutas que necesitan token (loguearse)

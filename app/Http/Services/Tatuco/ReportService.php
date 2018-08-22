<?php
namespace App\Http\Services\Tatuco;

use app\Http\Services\Gasolinera\AuditService;
use App\Models\Gasolinera\Account;
use Illuminate\Http\Response;
use PDF;
use Illuminate\Http\Request;
use App\Reports\src\ReportMedia\ExcelReport;
use App\Reports\src\ReportMedia\PdfReport;
use Optimus\Bruno\LaravelController;
use Optimus\Bruno\EloquentBuilderTrait;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Reports\src\ReportMedia\CSVReport;
class ReportService extends LaravelController
{

    use EloquentBuilderTrait;

    /**
     * @param Request $request*
     * @param $x_model = modelo del reporte
     * @param $x_namePlural = nombre en plural
     * @param $x_columns = columnas mapeadas del reporte
     * @param null $x_title = titulo del reporte
     * @param $x_status = nombre del campo status
     * @param $x_acc = nombre del campo de accounts
     * @param $x_created = nombre del campo de la fecha
     * @param null $x_select = select join
     * @return reporte en pdf, excel, csv
     */
    /*public function report(Request $request, $x_model, $x_namePlural, $x_columns, $x_title = null,
                           $x_status, $x_acc, $x_created, $x_select = null)
    {
        if (!JWTAuth::parseToken()->authenticate()->can('index.report')) { //consulto los permisos
            return (new response())->setStatusCode(403, 'no tienes permiso index.report');
        }

        //instancio fecha actual
        $now = Carbon::now()->format('Y-m-d');
        $format = $request->get('format');//formato
        $user = (new TatucoService())->currentUSer();
        //selecciono los datos de la cuenta para pasar al reporte
        $account = Account::where('acc_id',$user->acc_id)
            ->first();
        //$icon = '/home/zippyttech/PhpstormProjects/ControlCombustible-api/public/imagen/zipi.png';//imagen de la empresa local
        $icon = '/var/www/api/public/imagen/zipi.png';//imagen de la empresa produccion
        $acc_nam = $account->acc_nom;//nombre de la empresa
        $acc_ruc = $account->acc_ruc;//ruc de la empresa
        $foot = $user->use_nic;//datos que saldran en el reporte al final
        $title = $x_title?:"Reporte de ".$x_namePlural;//por si no viene titulo
        $queryBuilder = 0;
        $reqDate = $this->reqDate($fromDate, $toDate);//recibo la respuesta de la funcion
        $_columns = array();

        if(!$x_columns){ //si no vienen las columnas devuevlo el error
            return response()->json([
                'column' => $x_columns,
                'status' => false,
                'message' => 'Columnas del Reporte No especificadas en el Controller',
                'sintaxis' => '$this->clumns = ["Title" => "campo"]'
            ], 500);
        }

        foreach($x_columns as $column){//recorro las columnas en el foreach
            array_push($_columns, $column);
        }

        //depende de la respuesta obtenida en el reqDate, hago la consulta
        switch ($reqDate?:1) {
            case 1://si en el param va fecha inicio, fecha fin
                $meta = [
                    'Desde ' => $fromDate,
                    'Hasta ' => $toDate,
                ];
                $queryBuilder =$this->consult($x_select, $x_model, $_columns)
                    ->whereBetween($x_created, array($fromDate, $toDate))//por rango de fechas
                    ->where($x_status, true)//where si esta activo o eliminado
                    ->where($x_acc, $user->acc_id);//account logueado
                break;
            case 2://si en el param va fecha inicio
                $meta = [
                    'Del ' => $fromDate
                ];
                $queryBuilder =$this->consult($x_select, $x_model, $_columns)
                    ->whereDate($x_created, $fromDate)//por fecha especifica
                    ->where($x_status, true)//where si esta activo o eliminado
                    ->where($x_acc, $user->acc_id);//account logueado
                break;
            case 3://si en el param no va nada
                $meta = [];
                $queryBuilder =$this->consult($x_select, $x_model, $_columns)
                    ->where($x_status, true)
                    ->where($x_acc, $user->acc_id);//account logueado
                break;
            default://por defecto
                $meta = [];
                $queryBuilder =$this->consult($x_select, $x_model, $_columns)
                    ->where($x_status,true)//where si esta activo o eliminado
                    ->where($x_acc, $user->acc_id);//account logueado
                break;
        }

        switch ($format) {
            case 'xls':
                return (new ExcelReport())->of($title, $meta, $queryBuilder, $x_columns, $icon, $acc_nam, $acc_ruc, $foot)
                    ->setCss(['.head-content' => 'border-width: 0px'])
                    ->download('Reporte');
                break;
            case 'pdf':
                return (new PdfReport())->of($title, $meta, $queryBuilder, $x_columns, $icon, $acc_nam, $acc_ruc, $foot)
                    ->setCss(['.head-content' => 'border-width: 0px'])
                    ->limit(700)
                    ->stream();
                break;
            case 'csv':
                return (new CSVReport())->of($title, $meta, $queryBuilder, $x_columns, $icon, $acc_nam, $acc_ruc, $foot)
                    ->setCss(['.head-content' => 'border-width: 0px'])
                    ->download('reporte');
                break;
            default:
                $items = $queryBuilder->get();
                return response()->json($items, 200);
                break;
        }

    }*/



    /**
     * @param Request $request
     * @param $x_model = modelo del reporte
     * @param $x_fromDate = fecha inicio
     * @param $x_toDate = fecha fin
     * @param $x_status = nombre del campo status
     * @param $x_acc = nombre del campo de accounts
     * @param $x_created = nombre del campo de la fecha
     * @param $x_namePlural = nombre en plural
     * @param $x_columns = columnas mapeadas del reporte
     * @param $x_select = select join
     * @param null $x_title = titulo del reporte
     * @return reporte general en pdf, excel, csv
     */
    public function report(Request $request, $x_model, $x_fromDate, $x_toDate, $x_status, $x_acc, $x_created,
                                 $x_namePlural, $x_columns, $x_select, $x_title = null)
    {
        //consulto los permisos
        if ((new TatucoService())->checkPermission('index.report') == false ) {
            return  response()->json(["message" => "no tienes permiso para index.report"], 403)
                ->setStatusCode(403, 'no tienes permiso para listar registros de este modulo');
        }
        $user = (new TatucoService())->currentUSer();
        //selecciono los datos de la cuenta para pasar al reporte
        $account = Account::where('acc_id',$user->acc_id)
            ->first();
        $var = 1;
        //$icon = '/home/zippyttech/PhpstormProjects/ControlCombustible-api/public/imagen/zipi.png';//imagen de la  empresa local
        $icon = public_path().'/imagen/zipi.png';//imagen de la empresa produccion
        $acc_nam = $account->acc_nom;//nombre de la empresa
        $acc_ruc = $account->acc_ruc;//ruc de la empresa
        $foot = $user->use_nic;//datos que saldran en el reporte al final
        $title = $x_title?:"Reporte de ".$x_namePlural;//por si no viene titulo
        $_columns = array();
        $format = $request->get('format');

        if(!$x_columns){ //si no vienen las columnas devuevlo el error
            return response()->json([
                'column' => $x_columns,
                'status' => false,
                'message' => 'Columnas del Reporte No especificadas en el Controller',
                'sintaxis' => '$this->clumns = ["Title" => "campo"]'
            ], 500);
        }

        foreach($x_columns as $column){//recorro las columnas en el foreach
            array_push($_columns, $column);
        }

        $reqDate = $this->reqDate($x_fromDate, $x_toDate);//recibo la respuesta de la funcion

        //depende de la respuesta obtenida en el reqDate, hago la consulta
        switch ($reqDate?:1) {
            case 1://si en el param va fecha inicio, fecha fin*
                $meta = [
                    'Desde ' => $x_fromDate,
                    'Hasta ' => $x_toDate,
                ];
                $queryBuilder =$this->consult($x_select, $x_model, $_columns)
                    ->whereBetween($x_created, array($x_fromDate, $x_toDate))//por rango de fechas
                    ->where($x_status, true)//where si esta activo o eliminado
                    ->where($x_acc, $user->acc_id);//account logueado
                break;
            case 2://si en el param va fecha inicio
                $meta = [
                    'Del ' => $x_fromDate
                ];
                $queryBuilder =$this->consult($x_select, $x_model, $_columns)
                    ->whereDate($x_created, $x_fromDate)//por fecha especifica
                    ->where($x_status, true)//where si esta activo o eliminado
                    ->where($x_acc, $user->acc_id);//account logueado
                break;
            case 3://si en el param no va nada
                $meta = [];
                $queryBuilder =$this->consult($x_select, $x_model, $_columns)
                    ->where($x_status, true)
                    ->where($x_acc, $user->acc_id);//account logueado
                break;
            default://por defecto
                $meta = [];
                $queryBuilder =$this->consult($x_select, $x_model, $_columns)
                    ->where($x_status,true)//where si esta activo o eliminado
                    ->where($x_acc, $user->acc_id);//account logueado
                break;
        }


        switch ($format) {
            case 'xls':
                return (new ExcelReport())->of($title, $meta, $queryBuilder, $x_columns, $icon, $acc_nam, $acc_ruc, $foot)
                    ->setCss(['.head-content' => 'border-width: 0px'])
                    ->download('Reporte');
                break;
            case 'pdf':
                return (new PdfReport())->of($title, $meta, $queryBuilder, $x_columns, $icon, $acc_nam, $acc_ruc, $foot)
                    ->setCss(['.head-content' => 'border-width: 0px'])
                    ->limit(700)
                    ->download('reporte');
                break;
            case 'csv':
                return (new CSVReport())->of($title, $meta, $queryBuilder, $x_columns, $icon, $acc_nam, $acc_ruc, $foot)
                    ->setCss(['.head-content' => 'border-width: 0px'])
                    ->download('reporte');
                break;
            default:
                $items = $queryBuilder->get();
                return response()->json($items, 200);
                break;
        }

    }

    public function reqDate ($x_fromDate, $x_toDate){
        $var = 0;

        //existe fecha de inicio, de fin
        if(isset($x_fromDate) && isset($x_toDate)){
            $var = 1;
        }
        //si existe fecha de inicio pero no fecha fin
        if (isset($x_fromDate) && !isset($x_toDate)){
            $var = 2;
        }

        //si no existe ninguno
        if (!isset($x_fromDate) && !isset($x_toDate)){
            $var = 3;
        }
        return $var;
    }

    public function consult($x_select, $x_model, $_columns)
    {
        if($x_select) {
            return $x_select;
        }else{
            return $x_model::select($_columns);
        }
    }

}

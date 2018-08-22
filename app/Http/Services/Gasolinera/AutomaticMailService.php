<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\AutomaticMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Illuminate\Http\Response;


class AutomaticMailService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'automatic_mail';
        $this->model = new AutomaticMail();
        $this->namePlural = 'automatic_mails';
        $this->path = 'http://lina.zippyttech.com:';
        $this->port = '8000';
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
     * metodo que consulta los horarios de parametrizacion de correot
     */
    public function consultSendMail()
    {
        $hourDay = Carbon::now()->format('H:i');
        $numDay = $this->dayOfWeek();//funcion que convierte el nombre del dia en numero
        $query = AutomaticMail::where('aem_fre',$numDay)//consu lto los reportes por enviar
            ->orWhere('aem_fre',1)
            ->where('enable',true)
            ->where('aem_hou', $hourDay)
            ->where('aem_act',true)
            ->get();
        if(count($query)>0) {//si el array es mayor a 0
            foreach ($query as $q) {//recorro el array
                if ($q->aem_hou == $hourDay && $q->aem_act == true && $q->enable == true) {//consulto hora y activo o inactivo
                    if ($q->aem_fre == 1 || $q->aem_fre == $numDay) {//consulto hora
                        //recorro el array
                        $acc = $q->acc_id; //cuenta asociada
                        $body = $q->aem_bod;
                        $subject = $q->aem_asu;
                        $format = $q->aem_for;
                        $typeReport = $q->aem_tre;
                        $filter = $q->aem_fil;
                        $port = $q->aem_por;
                        $sender = $q->aem_sen;
                        $pass = $q->aem_pas;
                        $smtp = $q->aem_smt;
                        $to = $q->aem_to;

                        $pdf = 'http://toursentailandia.com/wp-content/uploads/2017/02/download-as-pdf.png';//imagen pdf
                        $xls = 'http://icons.iconarchive.com/icons/graphicloads/filetype/256/excel-xls-icon.png';//imagen xls
                        $csv = 'https://freeiconshop.com/wp-content/uploads/edd/csv-flat.png';//imagen csv

                        $endpoint = $this->typeReport($typeReport, $filter);//consulto el endpoint dependiendo del tipo de reporte
                        $report = $body; //variable que se enviara por correo
                        $report .= "<br>"; //variable que se enviara por correo
                        $url = $this->path . $this->port . $endpoint; //url

                        switch ($format) {//formato de envio del reporte
                            case 'pdf'://formato pdf
                                $report .= "<br><a href='$url $format'><img width='70' height='70' alt='reporte PDF' src='$pdf'/></a>";
                                break;
                            case 'xls'://formato xls
                                $report .= "<br><a href='$url $format'><img width='70' height='70' alt='reporte XLS' src='$xls'/></a>";
                                break;
                            case 'csv'://formato csv
                                $report .= "<br><a href='$url $format'><img width='70' height='70' alt='reporte CSV' src='$csv'/></a>";
                                break;
                            case 1://todos los formatos
                                $report .= "<br><a href='$url pdf'><img width='70' height='70' alt='reporte PDF' src='$pdf'/></a>";
                                $report .= "<a href='$url xls'><img width='70' height='70' alt='reporte XLS' src='$xls'/></a>";
                                $report .= "<a href='$url csv'><img width='70' height='70' alt='reporte CSV' src='$csv'/></a>";
                                break;
                            default://default pdf
                                $report .= "<br><a href='$url $format'><img width='70' height='70' alt='reporte PDF' src='$pdf'/></a>";
                                break;
                        }

                        // se asignan las credenciales de envio de correo
                        if ($port == 25) {
                            $credenciales = (new Swift_SmtpTransport($smtp, $port, 'tls'))
                                ->setUsername($sender)
                                ->setPassword($pass);
                        } else {
                            $credenciales = (new Swift_SmtpTransport($smtp, $port, 'ssl'))
                                ->setUsername($sender)
                                ->setPassword($pass);
                        }

                        // se instancia el envio de correo con las credenciales
                        $mail = new Swift_Mailer($credenciales);
                        $array_to = explode(",", $to);//si viene una cadena separada por , la convierte en array
                        //se crea el mensaje
                        $message = (new Swift_Message($subject))
                            ->setFrom($sender)
                            ->setTo($array_to)
                            ->setBody($body)
                            ->setBody($report, 'text/html');


                        $mail->send($message);
                        echo "enviado ";
                    }
                }
            }
        }
    }


    /**
     * metodo que arma el endpoint para el reporte
     * @param $x_typeReport = tipo del reporte 1 = reporte de salidas, etc
     * @param $x_filter = filtro del rango de fechas 1 mes actual, etc
     * @return endpoint con los parametros para consultar el correo
     */
    public function typeReport($x_typeReport, $x_filter){
        $now = Carbon::now(); //instancio fecha actual
        //token necesario para ver el correo
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly8xOTIuMTY4LjAuMTE0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNTIzMzA1OTQ2LCJleHAiOjE4NDczMDU5NDYsIm5iZiI6MTUyMzMwNTk0NiwianRpIjoiQjNWZ3N4d1FVWUlYRWsxaSJ9.ijBebqIbs2LZmVai87k_8EzwR1e8nx3YNa-c_q8Kr6E";
        switch ($x_typeReport){//tipo de reporte
            case 1: //reporte de salida
                switch ($x_filter){//filtros del reporte
                    case 1://mes actual
                        $toDate = $now->subDay(1)->addDay(1)->format('Y-m-d');//le agrego 1 dia
                        $fromDate = $now->subDay(31)->format('Y-m-d'); //resto 30 dias a la fecha actual
                        return $endpoint = "/api/reports/expenses/fuels?token=$token&from_date=$fromDate&to_date=$toDate&format=";
                        break;
                    case 2://año actual
                        $fromDate = $now->subYear(1)->format('Y-m-d'); //fecha de inicio
                        $toDate =$now->addYear(1)->addDay(1)->format('Y-m-d'); //fecha fin
                        return $endpoint = "/api/reports/expenses/fuels?token=$token&from_date=$fromDate&to_date=$toDate&format=";
                        break;
                    case 3://ultimos 3 meses
                        $fromDate = $now->subMonth(3)->format('Y-m-d'); //fecha de inicio
                        $toDate =$now->addMonth(3)->addDay(1)->format('Y-m-d'); //fecha fin
                        return $endpoint = "/api/reports/expenses/fuels?token=$token&from_date=$fromDate&to_date=$toDate&format=";
                        break;
                }//cierre switch filtro
                break;
            case 2: //para otro reporte
                break;
        }//cierre switch TipoReporte
    }

    /**
     * metdoo que transforma el nombre del dia de la semana en numero, Monday = 2, etc
     * @return numero del dia transformado
     */
    public function dayOfWeek(){
        $numDay = Carbon::now()->format('l');
        switch ($numDay){
            case 'Monday':
                return 2;
                break;
            case 'Tuesday':
                return 3;
                break;
            case 'Wednesday':
                return 4;
                break;
            case 'Thursday':
                return 5;
                break;
            case 'Friday':
                return 6;
                break;
            case 'Saturday':
                return 7;
                break;
            case 'Sunday':
                return 8;
                break;
            default:
                return 1;
                break;
        }

    }

    /**
     * metodo que hace el testeo smtp de la configuracion de correos automaticos
     * @param $x_smtp = servidor smtp
     * @param $x_port = puerto
     * @param $x_from = cuenta de correo de host
     * @param $x_pass = contraseña de la cuenta de correo
     * @return mensaje con la respuesta exitosa o fallida
     */
    public function testSmtp($x_smtp, $x_port, $x_from, $x_pass)
    {
        if($x_smtp == 'undefined' || $x_port == 'undefined' || $x_from == 'undefined' || $x_pass == 'undefined'){
            return  response()->json(["message" => "Los campos remitente, servidor, puerto y contrase&ntilde;a no pueden quedar vacios"], 500)
                ->setStatusCode(500, 'Los campos remitente, servidor, puerto y contrase&ntilde;a no pueden quedar vacios');
        }
        try{
            // se asignan las credenciales de envio de correo
            if ($x_port == 25) {
                $transport = (new Swift_SmtpTransport($x_smtp, $x_port, 'tls'));
                $transport->setUsername($x_from);
                $transport->setPassword($x_pass);
            } else {
                $transport = (new Swift_SmtpTransport($x_smtp, $x_port, 'ssl'));
                $transport->setUsername($x_from);
                $transport->setPassword($x_pass);
            }

            $mailer = new Swift_Mailer($transport);
            $mailer->getTransport()->start();

            return  response()->json(["message" => "Conexion establecida correctamente"], 200)
                ->setStatusCode(200, 'Conexion establecida correctamente');
        } catch (\Swift_TransportException $e) {
            $codeError = $e->getCode();

            switch ($codeError){
                case 0:
                    return  response()->json(["message" => "El servidor SMTP o el puerto son incorrectos"], 500)
                        ->setStatusCode(500, 'El servidor SMTP o el puerto son incorrectos');
                    break;
                case 535:
                    return  response()->json(["message" => "El correo o la contrase&ntilde;a son incorrectos"], 500)
                        ->setStatusCode(500, 'El correo o la contrase&ntilde;a son incorrectos');
                    break;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
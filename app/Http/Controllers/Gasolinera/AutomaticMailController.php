<?php

namespace App\Http\Controllers\Gasolinera;

use App\Http\Controllers\Tatuco\TatucoController;
use App\Http\Services\Gasolinera\AutomaticMailService;
use Illuminate\Http\Request;


class AutomaticMailController extends TatucoController
{
    public function __construct()
    {
        $this->service = new AutomaticMailService();
        $this->namePrimaryKey = 'aem_id';//llave primaria
        $this->status = 'aem_act';//campo de activo o eliminado
    }


    /**
     * @param Request $request
     * @return store de AutomaticMailService
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return update de AutomaticMailService
     */
    public function update($x_pk, Request $request)
    {
        return $this->service->update($this->namePrimaryKey,$x_pk, $this->status, $request);
    }


    /**
     * @param $x_smtp = servidor smtp
     * @param $x_port = puerto
     * @param $x_from = cuenta de correo de host
     * @param $x_pass = contraseña de la cuenta de correo
     * @return testSmtp de AutomaticMailService
     */
    public function testSmtp($x_smtp, $x_port, $x_from, $x_pass)
    {
        return $this->service->testSmtp($x_smtp, $x_port, $x_from, $x_pass);
    }

    public function consultSendMail()
    {
        return $this->service->consultSendMail();
    }

}

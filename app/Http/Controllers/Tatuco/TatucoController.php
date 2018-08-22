<?php

namespace App\Http\Controllers\Tatuco;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Services\Tatuco\TatucoService;
use App\Providers\EventServiceProvider;
use Composer\Script\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TatucoController extends Controller
{
    //atributos
    public $service;
    public $tatucoService;
    public $columns;
    public $namePrimaryKey;
    public $status;

    public function __construct(TatucoService $tatucoService){
        $this->tatucoService = $tatucoService;
    }

    /**
     * @return _index de tatucoService
     */
    public function index(Request $request)
    {
        return $this->service->_index($request, $this->status);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @return _show de tatucoService
     */
    public function show($x_pk)
    {
        return $this->service->_show($this->namePrimaryKey, $x_pk, $this->status);
    }

    /**
     * @param Request $request
     * @return _store de tatucoService
     */
    public function store(Request $request)
    {
        return $this->service->_store($request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @param Request $request
     * @return _update de tatucoService
     */
    public function update($x_pk, Request $request)
    {
       return $this->service->_update($this->namePrimaryKey, $x_pk, $this->status, $request);
    }

    /**
     * @param $x_pk = valor de la llave primaria
     * @return _destroy de tatucoService
     */
    public function destroy($x_pk)
    {
        //llamo al tatucoService
        return $this->service->_destroy($this->namePrimaryKey, $x_pk, $this->status);
    }

    /**
     * @return backup de tatucoService
     */
    public function backup(){
        //llamo al tatucoService
        return $this->tatucoService->backup();
    }



}

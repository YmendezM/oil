<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class RegionalConfiguration extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'rco_id';
    protected $table ="regional_configuration";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'rco_id', 'acc_id', 'cou_id', 'use_nic', 'rco_mon', 'rco_umv', 'rco_ump', 'rco_uml', 'rco_act'
    ];
}

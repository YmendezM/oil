<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Driver extends TatucoModel
{
    public $timestamps = true;
    public $incrementing = false;
    protected $primaryKey = 'dri_dni';
    protected $table ="drivers";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'dri_dni', 'dri_com', 'dri_nam', 'dri_lna', 'dri_lic', 'dri_pho', 'dri_mai', 'use_nic', 'sta_id', 'dri_ass', 'dri_act', 'acc_id'
    ];
}

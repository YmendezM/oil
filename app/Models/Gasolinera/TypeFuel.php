<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class TypeFuel extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'tfu_id';
    protected $table ="type_fuels";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'tfu_id', 'tfu_des', 'use_nic', 'tfu_act', 'acc_id'
    ];
}

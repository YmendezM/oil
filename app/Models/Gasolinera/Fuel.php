<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Fuel extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'fue_id';
    protected $table ="fuels";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'fue_id', 'fue_des', 'fue_oct', 'fue_qua', 'use_nic', 'tfu_id', 'fue_act', 'acc_id'
    ];
}

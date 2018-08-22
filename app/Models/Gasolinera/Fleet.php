<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Fleet extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'fle_id';
    protected $table ="fleets";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'fle_id','fle_nam', 'use_nic', 'fle_act', 'acc_id', 'fle_des'
    ];
}

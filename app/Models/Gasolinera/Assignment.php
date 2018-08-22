<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Assignment extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'ass_id';
    protected $table ="assignments";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'ass_id', 'use_nic', 'dri_dni',  'veh_pla', 'ass_des', 'ass_act', 'acc_id'
    ];
}

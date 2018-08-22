<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Countrie extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'cou_id';
    protected $table ="countries";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'cou_id' ,'cou_des','cou_uho', 'cou_act'
    ];
}

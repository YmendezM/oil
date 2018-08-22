<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Notification extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'not_id';
    protected $table ="notifications";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'not_id', 'not_des', 'exp_id',  'not_cmi', 'not_cex', 'view', 'not_act', 'acc_id'
    ];
}

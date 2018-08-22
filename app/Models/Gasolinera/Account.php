<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Account extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'acc_id';
    protected $table ="accounts";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'acc_id', 'acc_enc', 'acc_des', 'acc_dir', 'acc_mai', 'acc_ima', 'acc_nom', 'acc_ruc', 'acc_pho', 'acc_web', 'acc_act'
    ];

}

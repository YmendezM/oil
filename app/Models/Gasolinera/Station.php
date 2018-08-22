<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Station extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'sts_id';
    protected $table ="stations";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'sts_id', 'sts_nam', 'cit_id', 'sts_dir', 'sts_qut', 'sts_pho', 'sts_mai', 'use_nic', 'sts_act', 'acc_id'
    ];
}

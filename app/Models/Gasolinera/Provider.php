<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Provider extends TatucoModel
{
    public $timestamps = true;
    public $incrementing = false;
    protected $primaryKey = 'pve_dni';
    protected $table ="providers";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'pve_dni', 'pve_nam', 'pve_lna', 'pve_pho', 'pve_mai', 'use_nic', 'pve_act', 'acc_id'
    ];
}

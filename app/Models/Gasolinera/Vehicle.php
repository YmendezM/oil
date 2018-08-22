<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Vehicle extends TatucoModel
{
    public $timestamps = true;
    public $incrementing = false;
    protected $primaryKey = 'veh_pla';
    protected $table ="vehicles";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'veh_pla', 'veh_com', 'use_nic', 'tve_id', 'fle_id', 'bra_id', 'mod_id', 'sta_id', 'veh_ass', 'veh_act', 'acc_id',
        'veh_id'
    ];
}

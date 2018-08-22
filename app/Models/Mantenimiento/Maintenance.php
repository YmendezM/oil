<?php

namespace App\Models\Mantenimiento;

use App\Models\Tatuco\TatucoModel;

class Maintenance extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'mai_id';
    protected $table ="maintenances";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'mai_id', 'use_nic_en', 'mai_fec_ex', 'use_nic_ex', 'veh_pla', 'mai_des', 'sta_id', 'mai_act', 'acc_id'
    ];
}

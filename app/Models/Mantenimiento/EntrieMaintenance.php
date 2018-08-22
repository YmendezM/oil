<?php

namespace App\Models\Mantenimiento;

use App\Models\Tatuco\TatucoModel;

class EntrieMaintenance extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'ema_id';
    protected $table ="entries_maintenances";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'ema_id', 'dma_id', 'ema_des', 'ema_act', 'acc_id'
    ];
}

<?php

namespace App\Models\Mantenimiento;

use App\Models\Tatuco\TatucoModel;

class OutputMaintenance extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'oma_id';
    protected $table ="outputs_maintenances";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'oma_id', 'dma_id', 'oma_des', 'oma_act', 'acc_id'
    ];
}

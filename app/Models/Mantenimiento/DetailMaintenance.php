<?php

namespace App\Models\Mantenimiento;

use App\Models\Tatuco\TatucoModel;

class DetailMaintenance extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'dma_id';
    protected $table ="detail_maintenances";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'dma_id', 'mai_id', 'dsm_id', 'spa_id', 'mec_dni', 'dma_act', 'acc_id'
    ];
}

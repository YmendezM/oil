<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class DetailExpenseFuel extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'dex_id';
    protected $table ="detail_expenses_fuels";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'dex_id', 'created_at', 'dex_qua', 'dex_amu', 'dex_hor', 'exp_id', 'tfu_id', 'fue_id', 'tan_id', 'dex_act', 'acc_id'
    ];
}

<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;
use Carbon\Carbon;
use DB;

class ExpenseFuel extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'exp_id';
    protected $table ="expenses_fuels";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'exp_id', 'exp_amo', 'created_at', 'use_nic', 'ass_id', 'sts_id', 'exp_act', 'acc_id'
    ];

}

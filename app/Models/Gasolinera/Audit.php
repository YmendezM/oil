<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class Audit extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'aud_id';
    protected $table ="audits";
    protected $fillable = [
        // mapeo de columnas de la base de datos
        'aud_id', 'aud_use', 'aud_act', 'aud_mod',  'aud_ip', 'aud_dbe', 'aud_dnew'
    ];
}

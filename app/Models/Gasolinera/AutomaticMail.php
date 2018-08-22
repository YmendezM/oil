<?php

namespace App\Models\Gasolinera;

use App\Models\Tatuco\TatucoModel;

class AutomaticMail extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'aem_id';
    protected $table ="automatic_mails";
    protected $fillable = [
        // mapeo de columnas de la base de datos
        'aem_id', 'use_nic', 'aem_des', 'aem_bod',  'aem_asu', 'aem_hou', 'aem_fre', 'aem_for', 'aem_tre',
        'aem_fil', 'aem_por', 'aem_sen', 'aem_pas', 'aem_smt', 'aem_to', 'enable', 'aem_act', 'acc_id'
    ];
}

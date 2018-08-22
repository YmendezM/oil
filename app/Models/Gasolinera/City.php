<?php

namespace App\Models\Gasolinera;


use App\Models\Tatuco\TatucoModel;

class City extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'cit_id';
    protected $table ="cities";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'cit_id', 'cou_id' ,'cit_des', 'cit_act'
    ];
}

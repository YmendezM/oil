<?php

namespace App\Acl\Src\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table ="permission_role";
    protected $fillable = [
        //mapeo de columnas de la base de datos
        'id', 'permission_id', 'role_id'
    ];
}

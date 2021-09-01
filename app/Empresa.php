<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;
    //
    protected $table = 'empresas';

    protected $fillable = [
        'empresa',
        'usuario_creacion_id',
        'usuario_actualizacion_id',
        'created_at', 
        'updated_at',
        'deleted_at'
    ];
}

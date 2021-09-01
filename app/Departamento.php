<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    //
    use SoftDeletes;

    protected $table = 'departamentos';

    protected $fillable = [
        'empresa_id',
        'departamento',
        'usuario_creacion_id',
        'usuario_actualizacion_id',
        'created_at', 
        'updated_at',
        'deleted_at'
    ];

    
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'empresa_id')->withTrashed();
    }
}

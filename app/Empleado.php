<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    //
    use SoftDeletes;

    protected $table = 'empleados';

    protected $fillable = [
        'empresa_id',
        'departamento_id',
        'nombre',
        'paterno',
        'materno',
        'fecha_nacimiento',
        'correo_electronico',
        'genero',
        'telefono',
        'celular',
        'fecha_ingreso',
        'usuario_creacion_id',
        'usuario_actualizacion_id',
        'created_at', 
        'updated_at',
        'deleted_at'
    ];

    protected $dates=['fecha_nacimiento','fecha_ingreso'];

    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'empresa_id')->withTrashed();
    }

    public function departamento()
    {
        return $this->belongsTo('App\Departamento', 'departamento_id')->withTrashed();
    }

    public function getarregloGeneroAttribute()
    {
        return $genero=[
            null=>' -Selecciona-',
            'Masculino'=>' Masculino',
            'Femenino'=>' Femenino'
        ];
    }
    public function getarregloDepartamentoAttribute()
    {
       return Departamento::where('empresa_id',$this->empresa_id)->pluck('departamento', 'id')->prepend('-Selecciona-', '');
    }
}

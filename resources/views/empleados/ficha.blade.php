@extends('layouts.app')
@section('content')
<div class="card">
<div class="card-header input-group col-lg-12"> 
    <h2 class="col-lg-9">Ficha del Empleado</h2>
</div>

<div class="bd-example">
    <div class="input-group col-lg-12">
        <div class="col-lg-6 col-md-6">
            Empresa: 
            <label class="text-primary">
                {{ optional($empleado->empresa)->empresa }}
            </label>
        </div>    
        <div class="col-lg-6 col-md-6">
            Departamento: 
            <label class="text-primary">
                {{ optional($empleado->departamento)->departamento }}
            </label>
        </div>
    </div>  
    <div class="input-group col-lg-12">
        <div class="col-lg-4 col-md-4">
            Nombre: 
            <label class="text-primary">
                {{ $empleado->nombre }}
            </label>
        </div>    
        <div class="col-lg-4 col-md-4">
            Paterno: 
            <label class="text-primary">
                {{ $empleado->paterno }}
            </label>
        </div>
        <div class="col-lg-4 col-md-4">
            Materno: 
            <label class="text-primary">
                {{ $empleado->materno }}
            </label>
        </div>
    </div> 
    <div class="input-group col-lg-12">
        <div class="col-lg-4 col-md-4">
            Fecha de nacimiento: 
            <label class="text-primary">
                {{ optional($empleado->fecha_nacimiento)->format('d/m/Y') }}
            </label>   
        </div>
        <div class="col-lg-4 col-md-4">
            Correo electrónico: 
            <label class="text-primary">
                {{ $empleado->correo_electronico }}
            </label>
        </div>
        <div class="col-lg-4 col-md-4">
            Fecha de ingreso: 
            <label class="text-primary">
                {{ optional($empleado->fecha_ingreso)->format('d/m/Y') }}
            </label>           
        </div>
        
    </div>
    <div class="input-group col-lg-12">
    <div class="col-lg-4 col-md-4">
            Género: 
            <label class="text-primary">
                {{ $empleado->genero }}
            </label>
        </div>
        <div class="col-lg-4 col-md-4">
            Teléfono: 
            <label class="text-primary">
                {{ $empleado->telefono }}
            </label>
        </div>
        <div class="col-lg-4 col-md-4">
            Celular: 
            <label class="text-primary">
                {{ $empleado->celular }}
            </label>
        </div>
    </div>
    <div class="row">    
        <div class="col-md-12 input-group ">        
            <a href="{!! route('empleado.index') !!}" class="btn btn-light">Cancelar</a>
        </div>
    </div>

</div>
</div>

@endsection
@extends('layouts.app')
@section('content')
<div class="card-header input-group col-lg-12"> 
    <h2 class="col-lg-9">Empleado</h2>
</div>
<div class="bd-example">
{!! BootForm::open(['model' => $empleado, 'store' => 'empleado.store', 'update' => 'empleado.update']); !!}
    <div class="input-group col-lg-12">
        <div class="col-lg-6 col-md-6">
            {!! BootForm::select('empresa_id', 'Empresa: *', $empresas, old('empresa_id')) !!}
        </div>    
        <div class="col-lg-6 col-md-6">
            {!! BootForm::select('departamento_id', 'Departamento: *', $empleado->arregloDepartamento, old('departamento_id')) !!}
        </div>
    </div>  
    <div class="input-group col-lg-12">
        <div class="col-lg-4 col-md-4">
            {!! BootForm::text('nombre', 'Nombre: *', old('nombre')); !!}
        </div>    
        <div class="col-lg-4 col-md-4">
            {!! BootForm::text('paterno', 'Paterno: *', old('paterno')); !!}
        </div>
        <div class="col-lg-4 col-md-4">
            {!! BootForm::text('materno', 'Materno: *', old('materno')); !!}
        </div>
    </div> 
    <div class="input-group col-lg-12">
        <div class="col-lg-4 col-md-4">
        @php
     
            $readOnly= (is_null($empleado->fecha_ingreso)) ? '' : 'readonly';
            
        @endphp
            {!! BootForm::date("fecha_nacimiento", "Fecha de nacimiento: * ", old("fecha_nacimiento", optional($empleado->fecha_nacimiento)->format('Y-m-d')),[$readOnly]); !!}   
        </div>
        <div class="col-lg-4 col-md-4">
            {!! BootForm::text('correo_electronico', 'Correo electrónico: *', old('correo_electronico')); !!}
        </div>
        <div class="col-lg-4 col-md-4">
            {!! BootForm::date("fecha_ingreso", "Fecha de ingreso: * ", old("fecha_ingreso", optional($empleado->fecha_ingreso)->format('Y-m-d'))); !!}
        </div>
        
    </div>
    <div class="input-group col-lg-12">
    <div class="col-lg-4 col-md-4">
            {!! BootForm::select('genero', 'Genero: ', $empleado->arregloGenero, old('departamento_id')) !!}
        </div>
        <div class="col-lg-4 col-md-4">
            {!! BootForm::text('telefono', 'Teléfono: ', old('telefono')); !!}
        </div>
        <div class="col-lg-4 col-md-4">
            {!! BootForm::text('celular', 'Celular: ', old('celular')); !!}    
        </div>
    </div>
    <div class="row">    
        <div class="col-md-12 input-group ">        
            {!! BootForm::submit("Guardar"); !!}
            <a href="{!! route('empleado.index') !!}" class="btn btn-link">Cancelar</a>
        </div>
    </div>
 {!! Form::close() !!}
</div>
@endsection
@section('scriptBFile')
<script>
    $(document).ready(function() {
      $('#empresa_id').on('change', function(e){
        var empresa_id = e.target.value;
        $.get('{{ url("/")}}/consultasajax/getdepartamentobyempresa/' + empresa_id,function(data) {
            $('#departamento_id').empty();
            $.each(data, function(fetch, regenciesObj){
                $('#departamento_id').append('<option value="'+ regenciesObj.id +'">'+ regenciesObj.departamento +'</option>');
            })
        });
    });
});
    </script>
@endsection
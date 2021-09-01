@extends('layouts.app')
@section('content')
<div class="card-header input-group col-lg-12"> 
    <h2 class="col-lg-9">Empleados</h2>
    <a href="{{ route('empleado.create')}} " class="btn btn-primary">
        Agregar
    </a> 
</div>
    {!! BootForm::open(['id'=>'form', 'method' => 'GET']); !!}
    <div class="form-group">   
        <div class="row">
            <div class="col-md-6">
                {!! BootForm::select('empresa_id', 'Empresa : ', $empresas, old('empresa_id')) !!}
            </div>
            <div class="col-lg-6 col-md-6">
            {!! BootForm::select('departamento_id', 'Departamento: *', $empleado->arregloDepartamento, old('departamento_id')) !!}
        </div>
        </div>
        <div class="col-6 input-group">
            <label class="text-dark" style="line-height: 2;"> Empleado :&nbsp;</label>
            <input type="search" class="form-control col-8" id="empleado" name="empleado">
            <span class="col-2">
            {!! Form::submit('Buscar', ['class' => 'btn btn-light']); !!}                            
            </span>
        </div>                    
    </div> 
    {!! BootForm::close() !!}
<div class="table-responsive">
    <table style="display:{{ ($empleados->count()) ? 'show' : 'none' }}" class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Empleado</th>
            <th>Empresa</th>
            <th>Departamento</th>
            <th>Fecha nacimiento</th>
            <th>Correo electrónico</th>
            <th>Fecha ingreso</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
            @forelse($empleados as $empleado)
            <tr>
                <td>
                    <a href="{{ route('empleado.edit', $empleado) }}">
                    {{ $empleado->nombre.' '.$empleado->paterno .' '.$empleado->materno }} 
                    </a>
                </td>
                <td>{{ optional($empleado->empresa)->empresa  }}  </td>                
                <td>{{ optional($empleado->departamento)->departamento  }}  </td>   
                <td>{{ optional($empleado->fecha_nacimiento)->format('d/m/Y') }} </td>             
                <td>{{ $empleado->correo_electronico }} </td>             
                <td>{{ optional($empleado->fecha_ingreso)->format('d/m/Y') }} </td>    
                <td class="float-center">
                    {!! Form::model($empleado, ['method' => 'get', 'route' => ['empleado.show',$empleado] ]) !!}
                    {!! BootForm::submit("Consultar",['class'=>'btn btn-info']); !!}
                    {!! Form::close() !!}
                </td>              
                <td class="float-center">
                    {!! Form::model($empleado, ['method' => 'delete', 'route' => ['empleado.destroy',$empleado] ]) !!}
                    {!! BootForm::submit("Eliminar",['class'=>'btn btn-danger']); !!}
                    {!! Form::close() !!}
                </td>                            
                </tr>
            @empty
                <tr>
                    <td colspan="4">No se ha registrado información en este apartado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
@section('scriptBFile')
<script>
    $(document).ready(function() {
      $('#empresa_id').on('change', function(e){
        var empresa_id = e.target.value;
        $.get('{{ url("/")}}/consultasajax/getdepartamentobyempresa/' + empresa_id,function(data) {
            
            $.each(data, function(fetch, regenciesObj){
                $('#departamento_id').append('<option value="'+ regenciesObj.id +'">'+ regenciesObj.departamento +'</option>');
            })
        });
    });
});
    </script>
@endsection
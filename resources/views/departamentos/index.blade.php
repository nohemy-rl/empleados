@extends('layouts.app')
@section('content')
<div class="card-header input-group col-lg-12"> 
    <h2 class="col-lg-9">Departamentos</h2>
    <a href="{{ route('departamento.create')}} " class="btn btn-primary">
        Agregar
    </a> 
</div>
{!! BootForm::open(['id'=>'form', 'method' => 'GET']); !!}
                <div class="form-group">   
                    <div class="col-6 input-group">
                        <label class="text-dark" style="line-height: 2;"> Departamento :&nbsp;</label>
                        <input type="search" class="form-control col-8" id="departamento" name="departamento">
                        <span class="col-2">
                        {!! Form::submit('Buscar', ['class' => 'btn btn-light']); !!}                            
                        </span>
                    </div>                    
                </div> 
                {!! BootForm::close() !!}
<div class="table-responsive">
    <table style="display:{{ ($departamentos->count()) ? 'show' : 'none' }}" class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Empresa</th>
            <th>Departamento</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
            @forelse($departamentos as $departamento)
            <tr>
                <td>{{ optional($departamento->empresa)->empresa                }}
                </td>
                <td class="col-lg-10">
                    <a href="{{ route('departamento.edit', $departamento) }}">
                    {{ $departamento->departamento }} 
                    </a>
                </td>
                <td class="float-center">
                    {!! Form::model($departamento, ['method' => 'delete', 'route' => ['departamento.destroy',$departamento] ]) !!}
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
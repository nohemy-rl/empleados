@extends('layouts.app')
@section('content')
<div class="row">   
    <div class="col-12">

<div class="card-header input-group col-lg-12"> 
    <h2 class="col-lg-9">Empresas</h2>
    <a href="{{ route('empresa.create')}} " class="btn btn-primary">
        Agregar
    </a> 
</div>
    {!! BootForm::open(['id'=>'form', 'method' => 'GET']); !!}
    <div class="form-group">   
        <div class="col-6 input-group">
            <label class="text-dark" style="line-height: 2;"> Empresa :&nbsp;</label>
            <input type="search" class="form-control col-8" id="empresa" name="empresa">
            <span class="col-2">
            {!! Form::submit('Buscar', ['class' => 'btn btn-light']); !!}                            
            </span>
        </div>                    
    </div> 
    {!! BootForm::close() !!}
<div class="table-responsive">
    <table style="display:{{ ($empresas->count()) ? 'show' : 'none' }}" class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Empresa</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
            @forelse($empresas as $empresa)
            <tr>
                <td class="col-lg-10">
                    <a href="{{ route('empresa.edit', $empresa) }}">
                    {{ $empresa->empresa }} 
                    </a>
                </td>
                <td class="float-center">
                    {!! Form::model($empresa, ['method' => 'delete', 'route' => ['empresa.destroy',$empresa] ]) !!}
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
</div>
</div>

@endsection
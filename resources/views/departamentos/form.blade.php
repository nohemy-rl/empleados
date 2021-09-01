@extends('layouts.app')
@section('content')
<div class="card-header input-group col-lg-12"> 
    <h2 class="col-lg-9">Departamento</h2>
</div>
<div class="bd-example">
{!! BootForm::open(['model' => $departamento, 'store' => 'departamento.store', 'update' => 'departamento.update']); !!}
    <div class="col-lg-12 col-md-12">
        {!! BootForm::text('departamento', 'Departamento: *', old('departamento')); !!}
    </div>
    <div class="col-lg-12 col-md-12">
        {!! BootForm::select('empresa_id', 'Empresa: *', $empresas, old('empresa_id')) !!}
    </div>
    <div class="row">    
        <div class="col-md-12 input-group ">        
            {!! BootForm::submit("Guardar"); !!}
            <a href="{!! route('departamento.index') !!}" class="btn btn-link">Cancelar</a>
        </div>
    </div>
 {!! Form::close() !!}
</div>
@endsection
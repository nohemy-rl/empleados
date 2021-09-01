@extends('layouts.app')
@section('content')
<div class="card-header input-group col-lg-12"> 
    <h2 class="col-lg-9">Empresa</h2>
</div>
<div class="bd-example">
{!! BootForm::open(['model' => $empresa, 'store' => 'empresa.store', 'update' => 'empresa.update']); !!}
    <div class="col-lg-12 col-md-12">
        {!! BootForm::text('empresa', 'Empresa: *', old('empresa')); !!}
    </div>
    <div class="row">    
        <div class="col-md-12 input-group ">        
            {!! BootForm::submit("Guardar"); !!}
            <a href="{!! route('empresa.index') !!}" class="btn btn-link">Cancelar</a>
        </div>
    </div>
 {!! Form::close() !!}
</div>
@endsection
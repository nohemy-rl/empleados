@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Registro de usuario</h3>
    </div>
    <div class="card-body">
        {!! BootForm::open(['model' => $usuario, 'store' => 'usuario.store', 'update' => 'usuario.update', 'id'=>'form']) !!}
        <div class="row">
            <div class="col-lg-6 col-md-6">
                {!! BootForm::text('name', 'Nombre:', old('name'), ['maxlength'=>'200']) !!}
            </div>
            <div class="col-lg-6 col-md-6">
                {!! BootForm::email("email", "Correo electrónico:", old("email"), ['maxlength'=>'200']); !!}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                {!! BootForm::password('password', 'Password:') !!}
            </div>
            <div class="col-lg-6 col-md-6">
                {!! BootForm::password('password_confirmation', 'Confirmar password:') !!}
            </div>
        </div>
       
        <div class="col-lg-6 col-md-6">
        {!! BootForm::select('rol', 'Rol: *', $usuario->arregloRol, old('rol')) !!}
        </div>
     
            
            
       
        <div class="row">&nbsp;</div>
         
        <div class="row">
          <div class="col-md-12 text-left">
            <button type="submit" name="enviar" value="usuario" class="btn btn-primary">Guardar</button>
            <a href="{!! route('usuario.index') !!}" class="btn btn-light">Cancelar</a>
          </div>
        </div>
        {!! BootForm::close() !!}
    </div>
</div>
@endsection

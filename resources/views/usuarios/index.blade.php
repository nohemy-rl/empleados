@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-header input-group col-lg-12">
        <h2 class="col-lg-9">Usuarios</h2>
        <a href="{{ route('usuario.create') }}" class="btn btn-primary pull-right">
          Agregar
        </a>
  </div>
  <div class="card-body">
    {!! BootForm::open(['id'=>'form', 'method' => 'GET']); !!}
    <div class="row align-items-center">
        <div class="col-md-3">
            {!! BootForm::text('name', 'Nombre:', old('name', optional(request())->name), ['maxlength' => '50']); !!}
        </div>
        <div class="col-md-3">
            {!! BootForm::text('email', 'Correo electrónico:', old('email', optional(request())->email), ['maxlength' => '50',]); !!}
        </div>
        <div class="col-md-3">
            {!! Form::submit('Buscar', ['class' => 'btn btn-primary']); !!}
        </div>
    </div>
    {!! BootForm::close() !!}
   <div class="row">
      <div class="col-md-12">
          <div class="table-responsive">
              <table class="table toggle-circle">
                  <thead style="display:{{(count($usuarios)) ? "show" : "none"}}">
                      <tr>
                          <th>Nombre</th>
                          <th>Rol</th>
                          <th>Correo electrónico</th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse($usuarios as $usuario)
                          <tr>
                              <td>
                                  
                                      {{ $usuario->name }}
                                  
                              </td>
                              <td>{{ $usuario->rol }}</td>
                              <td>{{ $usuario->email }}</td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="4">No se ha registrado este usuario</td>
                          </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scriptBFile')
@endsection

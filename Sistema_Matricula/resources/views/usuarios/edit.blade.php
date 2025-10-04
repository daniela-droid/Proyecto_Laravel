@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Editar Usuarios</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">Editar Usuarios</div>
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm w-50" value="{{ $usuario->nombre }}" required>
                </div>

                 <div class="form-group">
                    <label for="gmail">Gmail</label>
                    <input type="text" name="gmail" class="form-control form-control-sm w-50" value="{{ $usuario->gmail}}" required>
                </div>

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" class="form-control form-control-sm w-50" value="{{ $usuario->password}}" required>
                </div>

                  <div class="form-group">
                    <label for="rol">Rol</label>
                    <input type="text" name="rol" class="form-control form-control-sm w-50" value="{{ $usuario->rol}}" required>
                </div>

              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
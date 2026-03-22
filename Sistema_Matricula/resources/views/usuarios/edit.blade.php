@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Modificar datos del usuario</div>
        <div class="card-body">

            {{-- IMPORTANTE: Bloque para ver por qué falla la validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" name="Email" class="form-control form-control-sm w-50" value="{{ old('Email', $usuario->Email) }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Nuevo Password (dejar en blanco para no cambiar)</label>
                    <input type="password" name="password" class="form-control form-control-sm w-50">
                    <small class="text-muted">Si no desea cambiar la contraseña, deje este campo vacío.</small>
                </div>


                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select name="rol" class="form-control form-control-sm w-50" required>
                        <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>admin</option>
                        <option value="docentes" {{ $usuario->rol == 'docentes' ? 'selected' : '' }}>docentes</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
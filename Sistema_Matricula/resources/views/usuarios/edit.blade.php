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

            <form class="edit-form" action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Email">Email</label>
                            <input type="email" name="Email" class="form-control form-control-sm" value="{{ old('Email', $usuario->Email) }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="password">Nuevo Password</label>
                            <input type="password" name="password" class="form-control form-control-sm">
                            <small class="text-muted">Dejar en blanco para no cambiar</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="rol">Rol</label>
                            <select name="rol" class="form-control form-control-sm" required>
                                <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>admin</option>
                                <option value="docentes" {{ $usuario->rol == 'docentes' ? 'selected' : '' }}>docentes</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
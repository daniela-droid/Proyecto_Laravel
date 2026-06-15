@extends('adminlte::page')

@section('title', 'Editar Admin')

@section('content')
<div class="container">
    <div class="card">
            <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Editar Admin</div>
        <div class="card-body">
            <form class="edit-form"  action="{{ route('admins.update', $admin->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="id_usuarios">Usuario</label>
                                    <select name="id_usuarios" class="form-control form-control-sm" required>
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}" {{ $admin->id_usuarios == $usuario->id ? 'selected' : '' }}>
                                                {{ $usuario->Email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="Nombre">Nombre</label>
                                    <input type="text" name="Nombre" class="form-control form-control-sm" value="{{ $admin->Nombre }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="Apellido">Apellido</label>
                                    <input type="text" name="Apellido" class="form-control form-control-sm" value="{{ $admin->Apellido }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="Cargo">Cargo</label>
                                    <input type="text" name="Cargo" class="form-control form-control-sm" value="{{ $admin->Cargo }}" required>
                                </div>
                            </div>
                        </div>

                   
                

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('admins.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

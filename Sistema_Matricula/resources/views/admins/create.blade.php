@extends('adminlte::page')

@section('title', 'Agregar Admin')

@section('content')
<div class="container">
    <div class="card shadow-sm">
      <!--  <div class="card-header bg-green text-white">-->
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar un Nuevo admin</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admins.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}

            <div class="form-group mb-2">
                <label for="id_usuarios">id de usuarios</label>
                <select name="id_usuarios" class="form-control form-control-sm w-50" required>
                 
                    <option value="" disabled selected> seleccione el id del usuario que contiene su email </option>
                    @foreach($usuarios as $usuario)
                        {{-- Importante: value lleva el ID, pero el usuario ve el Nombre --}}
                        <option value="{{ $usuario->id }}">{{ $usuario->id}} {{ $usuario->Email }}</option>
                    @endforeach
                </select>
              
            </div>

                <div class="form-group mb-2">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="Cargo">Cargo</label>
                    <input type="text" name="Cargo" class="form-control form-control-sm w-50" required>
                </div>

               
         
                
                   <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('admins.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

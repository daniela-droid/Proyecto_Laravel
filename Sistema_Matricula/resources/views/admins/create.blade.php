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

                <div class="row">
                    <div class="col-md-6">
            <div class="form-group mb-2">
                <label for="id_usuarios">id de usuarios</label>
                <select name="id_usuarios" class="form-control " required>
                 
                    <option value="" disabled selected> seleccione el id del usuario que contiene su email </option>
                    @foreach($usuarios as $usuario)
                        {{-- Importante: value lleva el ID, pero el usuario ve el Nombre --}}
                        <option value="{{ $usuario->id }}">{{ $usuario->id}} {{ $usuario->Email }}</option>
                    @endforeach
                </select>
              
            </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control " required>
                </div>

                </div>
            </div>

                <div class="row">
                    <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control " required>
                </div>
                </div>
                 <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="Cargo">Cargo</label>
                    <input type="text" name="Cargo" class="form-control " required>
                </div>
                </div>
               </div>
         
                
                   <button type="submit" class="btn btn-primary">   <i class="fas fa-save"></i> Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('admins.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
  <script>
        document.addEventListener("DOMContentLoaded", function() {
    // Usamos la URL actual para que cada formulario tenga su propio "baúl" de datos
    const storagePrefix = "form_data_" + window.location.pathname;
    const form = document.querySelector('form');
    
    if (!form) return; // Si no hay formulario en esta página, no hace nada

    const inputs = form.querySelectorAll('input, select, textarea');

    // 1. CARGAR: Al entrar, rellena lo que encuentre para ESTA página
    inputs.forEach(input => {
        if (input.name && input.type !== 'password') { 
            const savedValue = localStorage.getItem(storagePrefix + "_" + input.name);
            if (savedValue !== null) {
                input.value = savedValue;
            }
        }
    });

    // 2. GUARDAR: Escucha cambios en cualquier input
    form.addEventListener('input', function(e) {
        if (e.target.name && e.target.type !== 'password') {
            localStorage.setItem(storagePrefix + "_" + e.target.name, e.target.value);
        }
    });

    // 3. LIMPIAR: Borra solo cuando el usuario guarda (submit)
    form.addEventListener('submit', function() {
        inputs.forEach(input => {
            localStorage.removeItem(storagePrefix + "_" + input.name);
        });
    });
});

        </script>
@stop

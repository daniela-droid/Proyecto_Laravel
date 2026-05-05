@extends('adminlte::page')

@section('title', 'Turnos')

@section('content_header')
    <h1>Lista de Turnos</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Agregar Turno</div>
        <div class="card-body">
         
            <form action="{{ route('turnos.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}


                <div class="row">
                    <div class="col-md-4">
                         <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control " required>
                </div>
                    </div>
                    <div class="col-md-4">

                 <div class="form-group">
                    <label for="Descripcion">Descripcion</label>
                    <input type="text" name="Descripcion" class="form-control " required>
                </div>
                    </div>
              
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-4">
                         <button type="submit" class="btn btn-primary">   <i class="fas fa-save"></i> Guardar</button>
               
                <a href="{{ route('turnos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>

               
            </form>
        </div>
    </div>
</div>
@stop
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
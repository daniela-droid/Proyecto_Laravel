@extends('adminlte::page')

@section('title', 'Agregar Modalidad')

@section('content')
<div class="container">
    <div class="card shadow-sm">
      <!--  <div class="card-header bg-green text-white">-->
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Modalidad</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('modalidades.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}

          
                <div class="row">
                    <div class="col-md-4">
                 <div class="form-group mb-2">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control " required>
                </div>
                    </div>
                    <div class="col-md-4">

                <div class="form-group mb-2">
                    <label for="codigo">Código</label>
                    <input type="text" name="codigo" class="form-control" required>
                </div>
                    </div>
                    <div class="col-md-4">

                <div class="form-group mb-2">
                       <label for="descripcion">Descripción</label>
                    <input type="text" name="descripcion"  class="form-control" required>
                </div>
                    </div>
                </div>
               
                    <div class="row">
                        <div class="col-md-12">
                    <hr>
                        </div>
                        <div class="col-md-4">
                            
                   <button type="submit" class="btn btn-primary">   <i class="fas fa-save"></i> Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('modalidades.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>

                
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
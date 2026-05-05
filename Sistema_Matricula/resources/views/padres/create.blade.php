@extends('adminlte::page')

@section('title', 'Agregar Padres')

@section('content')
<div class="container">
    <div class="card shadow-sm">
      <!--  <div class="card-header bg-green text-white">-->
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Padres</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('padres.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}

            <div class="row">
                <div class="col-md-4">
                <div class="form-group mb-2">
                    <label for="Nombre_o_Tutor">Nombre o Tutor</label>
                    <input type="text" name="Nombre_o_Tutor" class="form-control " required>
                </div>
                </div>
                <div class="col-md-4">

                <div class="form-group mb-2">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control " required>
                </div>

            
                </div>
                <div class="col-md-4">

                <div class="form-group mb-2"> 
                    <label for="Email">Email</label>
                     <input type="Email" name="Email" class="form-control " required>
              
                </div>
                </div>
            </div>

              <div class="row">
                <div class="col-md-4">
 
                <div class="form-group mb-2"> 
                    <label for="Cedula">Cedula</label>
                     <input type="text" name="Cedula" class="form-control " required>
              
                   </div>
                </div>
                <div class="col-md-4">
             <div class="form-group mb-2">
                    <label for="Telefono">Telefono</label>
                    <input type="text" name="Telefono" class="form-control " required>
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
                <a href="{{ route('padres.index') }}" class="btn btn-secondary">Cancelar</a>
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
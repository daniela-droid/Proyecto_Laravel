@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1>Lista de Reportes</h1>
@stop

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">Agregar Reporte</div>
        <div class="card-body">
          <form action="{{ route('reportesadm.store') }}" method="POST">
                @csrf 

                <div class="row">
                    <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label for="titulo">Título de Reporte:</label>
                    <input type="text" name="titulo" class="form-control " required>
                </div>
                    </div>
                  
                   
                    <div class="col-md-4">
                    <div class="form-group mb-3">
                    <label for="categoria">Categoría:</label>
                    <select name="categoria" class="form-control " required>
                        <option value="sistema">Sistema</option>
                        <option value="infraestructura">Infraestructura</option>
                        <option value="personal">Personal</option>
                        <option value="otros">Otros</option>
                    </select>
                </div>
                    </div>
                </div>

            <div class="row">
                  <div class="col-md-8">
                      <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                  <textarea name="descripcion" rows="4" 
                    class="form-control f" 
                    placeholder="Escribe una descripción detallada..." required></textarea>
                </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-4">
                       <button type="submit" class="btn btn-primary">   <i class="fas fa-save"></i> Guardar</button>
                     <a href="{{route('reportesadm.index')}}" class="btn btn-secondary">Cancelar</a>
              
                    </div>
                
                </div>

        
            </form>
        </div>
    </div>
</div>
@stop
@section('js')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>

<script>
tinymce.init({
    selector: '#descripcion'
});
</script>

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
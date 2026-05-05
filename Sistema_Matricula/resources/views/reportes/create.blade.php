@extends('adminlte::page')

@section('title', 'Reportes')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Lista de Reportes</h1>
@stop

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">Agregar Reporte</div>
        <div class="card-body">
          <form action="{{ route('reportes.store') }}" method="POST">
                @csrf 

          <div class="row">
            <div class="col-md-4">
            <div class="form-group mb-2">
                        <label for="id_estudiante">Estudiantes</label>
                        <div class="input-group ">
                            <input type="hidden" name="id_estudiante" id="id_estudiante" required>
                            
                            <input type="text" id="nombre_stu_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalstu">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('estudiantes.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                           </div>
                    </div>
            </div>
            <div class="col-md-4">
                 <div class="form-group mb-3">
                    <label for="titulo">Título de Reporte:</label>
                    <input type="text" name="titulo" class="form-control " required>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                  <textarea name="descripcion" rows="4" 
                    class="form-control form-control-sm w-50" 
                    placeholder="Escribe una descripción detallada..." required></textarea>
                   
                </div>

               
            </div>
            <div class="col-md-4">
           <div class="form-group mb-3">
                    <label for="tipo">Tipo:</label>
                    <select name="tipo" class="form-control " required>
                        <option value="conducta">Conducta</option>
                        <option value="rendimiento">Rendimiento</option>
                        <option value="asistencia">Asistencia</option>

                    </select>
                </div>
            </div>
          </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
                <div class="col-md-4">
              <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Guardar</button>
                     <a href="{{route('reportes.index')}}" class="btn btn-secondary">Cancelar</a>
                
                </div>
            </div>
            
        

            
            </form>
        </div>
    </div>
</div>
@include('components.modal_rep_estudiantes')
@stop

@section('js')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>

<script>
tinymce.init({
    selector: '#descripcion'
});

 function seleccionarEstu(id, nombreCompleto) {
                        $('#id_estudiante').val(id);
                        $('#nombre_stu_display').val(nombreCompleto);
                        $('#modalstu').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_stu_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                        });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalstu').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
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
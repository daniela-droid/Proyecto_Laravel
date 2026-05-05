@extends('adminlte::page')
@section('title','Horarios')
@section('plugins.Datatables', true)
@section('content_header')
<h2>Crear Horario</h2>
@stop

@section('content')

<div class="container">
    <div class="card">
      <div class="card-header"> <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Horario</h4></div>
           
        <div class="card-body">

        <form action="{{route('horarios.store')}}" method="POST">
             @csrf 


            <div class="row">
                <div class="col-md-4">
                <div class="form-group mb-2">
                        <label for="id_grupo">Secciones</label>
                        <div class="input-group ">
                            <input type="hidden" name="id_grupo" id="id_grupo" required>
                            
                            <input type="text" id="nombre_sec_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalsec">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('grupos.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                </div>
            </div>

                </div>
                <div class="col-md-4">

                      <div class="form-group mb-2">
                        <label for="id_asignatura">Asignaturas</label>
                        <div class="input-group ">
                            <input type="hidden" name="id_asignatura" id="id_asignatura" required>
                            
                            <input type="text" id="nombre_asig_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalasig">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('asignaturas.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                      </div>
                    </div>

                </div>
                <div class="col-md-4">
                <div class="form-group mb-2">
                        <label for="id_docente">Docentes</label>
                        <div class="input-group ">
                            <input type="hidden" name="id_docente" id="id_docente" required>
                            
                            <input type="text" id="nombre_doc_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modaldoc">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('docentes.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                    </div>
            </div>
                </div>
            </div>

              <div class="row">
                <div class="col-md-4">
            <div class="form-group mb-2">
                        <label for="id_aula">Aulas</label>
                        <div class="input-group ">
                            <input type="hidden" name="id_aula" id="id_aula" required>
                            
                            <input type="text" id="nombre_aula_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalaula">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('aulas.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                    </div>
            </div>

                </div>
                <div class="col-md-4">
                   <div class="form-group mb-2"> 
                    <label for="Dia_semana">Dia de Semana</label>
                 <select name="Dia_semana" class="form-control" required> 
                    <option value="Lunes">Lunes</option> 
                    <option value="Martes">Martes</option>
                    <option value="Miercoles">Miercoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                    <option value="Sabado">Sabado</option>
                </select>
                 </div>
                </div>
                <div class="col-md-4">
               <div class="form-group mb-2">
               <label for="Hora_inicio">Hora de Inicio</label>
                 <input type="time" name="Hora_inicio"style="background-color:lightblue" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">

                  <div class="form-group mb-2">
                 <label for="Hora_fin">Hora de Culminacion</label>
                 <input type="time" name="Hora_fin" style="background-color:lightblue"class="form-control " required>
                </div>

                </div>
            </div>

              <div class="row">
                <div class="col-md-12">
        <hr>
                </div>
                <div class="col-md-4">

               
                     <button type="submit" class="btn btn-primary">   <i class="fas fa-save"></i> Guardar</button>
                     <a href="{{route('horarios.index')}}" class="btn btn-secondary">Cancelar</a>
             
                </div>
               
            </div>
               
        
                </form>

             
        </div>
    </div>
</div>


    @include('components.modal_horario_grupo')
    @include('components.modal_horario_asig')
    @include('components.modal_horario_docente')
    @include('components.modal_horario_aula')
@stop
 {{-- 2. EL JAVASCRIPT VA EN SU PROPIA SECCIÓN --}}
        @section('js')
                        <script>
                        function seleccionarGrupos(id, nombreCompleto) {
                        $('#id_grupo').val(id);
                        $('#nombre_sec_display').val(nombreCompleto);
                        $('#modalsec').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_sec_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                        });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalsec').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
                    });
                    ////////////////secciones//////////////////
                      function seleccionarAsig(id, nombreCompleto) {
                        $('#id_asignatura').val(id);
                        $('#nombre_asig_display').val(nombreCompleto);
                        $('#modalasig').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_asig_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                      });
                       // Activar el foco en el buscador al abrir el modal
                        $('#modalasig').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
                    });
                    //////////////////docentes////////////////////////////////
                     function seleccionarDocentes(id, nombreCompleto) {
                        $('#id_docente').val(id);
                        $('#nombre_doc_display').val(nombreCompleto);
                        $('#modaldoc').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_doc_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                      });
                       // Activar el foco en el buscador al abrir el modal
                        $('#modaldoc').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
                    });
                    /////////////////aulas////////////////////////
                     function seleccionarAulas(id, nombreCompleto) {
                        $('#id_aula').val(id);
                        $('#nombre_aula_display').val(nombreCompleto);
                        $('#modalaula').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_aula_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                      });
                       // Activar el foco en el buscador al abrir el modal
                        $('#modalaula').on('shown.bs.modal', function () {
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
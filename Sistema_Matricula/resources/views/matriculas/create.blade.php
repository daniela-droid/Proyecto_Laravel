@extends('adminlte::page')

@section('title', 'Matriculas')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Lista de Matriculas</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
           <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
        <div class="card-header">Agregar Matricula</div>
        <div class="card-body">
         
            <form action="{{ route('matriculas.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}


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
                               
                            </div>
                         
                           </div>
                    </div>
                    </div>
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
                             
                            </div>
                         
                    </div>
                 </div>

                    </div>
                    <div class="col-md-4">

                <div class="form-group mb-3">
                    <label for="id_periodo_academicos"> Periodos Academicos</label>
                    <select name="id_periodo_academicos" class="form-control " required>
                        <option value="" disabled selected>-- Seleccione  --</option>
                        @foreach($periodos as $periodo)
                        <option value="{{$periodo->id }}">{{$periodo->Nombre }}</option>
                        @endforeach
                    </select>
                </div>
                </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label for="fecha_matricula">Fecha</label>
                    <input type="date" name="fecha_matricula" class="form-control " required>
                 </div>
                    </div>
                    <div class="col-md-4">

                     <div class="form-group mb-2"> 
                   <label for="">Estado</label>
                 <select name="estado" class="form-control " required> 
                    <option value="Activo">Activo</option> 
                    <option value="Retirado">Retirado</option> 
                    <option value="Suspendido">Suspendido</option> 
                    <option value="Expulsado">Expulsado</option> 
                </select>
                 </div>
                    </div>
                    <div class="col-md-4">
                        
                 <div class="form-group mb-2">
                    <label for="observaciones">Observaciones</label>
                    <input type="text" name="observaciones" class="form-control " required>
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
                <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
             


            </form>
        </div>
    </div>
</div>
        @include('components.modal_matricula_estudiantes')
        @include('components.modal_matricula_sec')
@stop


        {{-- 2. EL JAVASCRIPT VA EN SU PROPIA SECCIÓN --}}
        @section('js')
                        <script>
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
                    ////////////////secciones//////////////////
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
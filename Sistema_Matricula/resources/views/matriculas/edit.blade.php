@extends('adminlte::page')

@section('title', 'Matriculas')

@section('plugins.Datatables', true)
@section('content_header')
    <h1>Editar Matriculas</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">Editar Matriculas</div>
        <div class="card-body">
            <form action="{{ route('matriculas.update', $matricula->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

               <div class="form-group mb-2">
                    <label for="id_estudiante">Estudiantes</label>
                    <div class="input-group w-50">
                        <input type="hidden" name="id_estudiante" id="id_estudiante" value="{{ $matricula->id_estudiante }}" required>
                        
                        <input type="text" id="nombre_stu_display" 
                            class="form-control form-control-sm" 
                            value="{{ $matricula->estudiantes->Nombre }} {{ $matricula->estudiantes->Apellido }}" 
                            readonly required>
                        
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalstu">
                                <i class="fas fa-search"></i> Cambiar
                            </button>
                        </div>
                    </div>
                </div>

               <div class="form-group mb-2">
                    <label for="id_grupo">Secciones</label>
                    <div class="input-group w-50">
                        <input type="hidden" name="id_grupo" id="id_grupo" value="{{ $matricula->id_grupo }}" required>
                        
                        <input type="text" id="nombre_sec_display" 
                            class="form-control form-control-sm" 
                            value="{{ $matricula->grupos->Descripcion}}" 
                            readonly required>
                        
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalsec">
                                <i class="fas fa-search"></i> Cambiar
                            </button>
                        </div>
                    </div>
                </div>

             <div class="form-group mb-3">
                <label for="id_periodo_academicos">Periodos Academicos</label>
                <select name="id_periodo_academicos" class="form-control form-control-sm w-50" required>
                    @foreach($periodos as $periodo)
                       <option value="{{$periodo->id }}" {{$matricula->id_periodo_academicos == $periodo->id ? 'selected' : ''}}
                       >{{$periodo->Nombre }}</option>
                    @endforeach
                </select>
            </div>
           
            

             <div class="form-group mb-2">
                    <label for="fecha_matricula">Fecha</label>
                    <input type="date" name="fecha_matricula" class="form-control form-control-sm w-50" value="{{$matricula->fecha_matricula}}"required>
            </div>

             <div class="form-group mb-2"> 
                    <label for="">Estado</label>
                 <select name="estado" class="form-control form-control-sm w-50" value="{{$matricula->estado}}"required> 
                    <option value="Activo">Activo</option> 
                    <option value="Retirado">Retirado</option> 
                    <option value="Suspendido">Suspendido</option> 
                    <option value="Expulsado">Expulsado</option> 
                </select>
                 </div>

                 <div class="form-group mb-2">
                    <label for="observaciones">Observaciones</label>
                    <input type="text" name="observaciones" class="form-control form-control-sm w-50" value="{{$matricula->observaciones}}" required>
                </div>

              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
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
@stop
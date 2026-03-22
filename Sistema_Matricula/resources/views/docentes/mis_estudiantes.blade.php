@extends('adminlte::page')

@section('title', 'Mis Estudiantes')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-student-alt mr-2"></i>Estudiantes Asignados</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary card-success">
        <div class="card-header">
            <h3 class="card-title">Listado de Estudiantes Asignados</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped">
                <thead class="alert-success">
                    <tr>
                        <th>Grado</th>
                        <th>Seccion</th>
                        <th>Asignatura</th>
                        <th>Estudiantes</th>
                    </tr>
                </thead>
                <tbody>
                                @forelse($horarios as $horario)
            <tr>
                <td>{{ $horario->grupo->grados->Nombre ?? ''}}</td>
                <td>{{ $horario->grupo->Descripcion ?? '' }}</td>
                <td>{{ $horario->asignatura->Nombre ?? '' }}</td>
                <td>
                    <button type="button" 
                            class="btn btn-info btn-sm" 
                            onclick="verEstudiantes('{{ $horario->grupo->grados->Nombre }} - {{ $horario->grupo->Descripcion }}', {{ json_encode($horario->grupo->estudiantes) }})"
                            data-toggle="modal" 
                            data-target="#modalEstudiantes">
                        <i class="fas fa-users"></i> Ver Estudiantes
                    </button>
                </td>
            </tr>
        @empty
            @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <small class="text-muted">Si hay un error en tu horario, contacta al Administrador.</small>
        </div>
    </div>
</div>


        {{-- 1. EL MODAL SE INCLUYE AQUÍ (Antes del stop del contenido) --}}
            @include('components.modal_estudiantes')

@stop

@section('css')
    <style>
        .table thead th { vertical-align: middle; text-align: center; }
        .table tbody td { vertical-align: middle; text-align: center; }
    </style>
@stop

 @section('js')
<script>
    function verEstudiantes(titulo, estudiantes) {
        // Ponemos el nombre del Grado y Sección en el título
        $('#tituloModal').text('Estudiantes de: ' + titulo);
        
        let tabla = $('#lista_estudiantes');
        tabla.empty(); // Limpiamos la lista anterior

        if (estudiantes.length > 0) {
            // Recorremos los estudiantes y creamos las filas
            estudiantes.forEach((estudiante, index) => {
                tabla.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${estudiante.Nombre} ${estudiante.Apellido}</td>
                    </tr>
                `);
            });
        } else {
            tabla.append('<tr><td colspan="2" class="text-center text-muted">No hay estudiantes en esta sección.</td></tr>');
        }
    }
</script>
@stop
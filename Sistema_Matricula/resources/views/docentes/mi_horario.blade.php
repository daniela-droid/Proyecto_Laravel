@extends('adminlte::page')

@section('title', 'Mi Horario')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-calendar-alt mr-2"></i>Mi Horario Personal</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Listado de clases asignadas</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped">
                <thead class="bg-primary bg-success">
                    <tr>
                        <th>Día</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Asignatura</th>
                        <th>Sección</th>
                        <th>Aula</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($horarios as $horario)
                        <tr>
                            <td><span class="badge badge-info">{{ $horario->Dia_semana }}</span></td>
                            <td>{{ $horario->Hora_inicio }}</td>
                            <td>{{ $horario->Hora_fin }}</td>
                            <td>{{ $horario->asignatura->Nombre ?? '' }}</td>
                            <td>{{ $horario->grupo->Descripcion ?? '' }}</td>
                            <td>
                                <span class="text-bold text-success">
                                    <i class="fas fa-door-open"></i> {{ $horario->aula->Nombre ?? 'N/A' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <p class="mt-3">No tienes horarios asignados todavía.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <small class="text-muted">Si hay un error en tu horario, contacta al Administrador.</small>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .table thead th { vertical-align: middle; text-align: center; }
        .table tbody td { vertical-align: middle; text-align: center; }
    </style>
@stop
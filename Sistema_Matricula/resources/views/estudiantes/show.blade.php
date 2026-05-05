@extends('adminlte::page')

@section('title', 'Detalle del Estudiante')

@section('content_header')
    <h1>Detalles del Estudiante</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- COLUMNA IZQUIERDA: INFORMACIÓN PERSONAL --}}
        <div class="col-md-4">
            <div class="card card-info card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        {{-- Icono representativo o foto --}}
                        <i class="fas fa-user-graduate fa-4x img-fluid img-circle text-info mb-3"></i>
                    </div>

                    <h3 class="profile-username text-center">{{ $estudiante->Nombre }} {{ $estudiante->Apellido }}</h3>
                    <p class="text-muted text-center">Código: {{ $estudiante->Código_Persona }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Sexo</b> <a class="float-right text-dark">{{ $estudiante->Sexo }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Edad</b> <a class="float-right text-dark">{{ $estudiante->edad }} años</a>
                        </li>
                        <li class="list-group-item">
                            <b>Celular</b> <a class="float-right text-dark">{{ $estudiante->Celular }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Comarca</b> <a class="float-right text-dark">{{ $estudiante->comarca->Comarca }}</a>
                        </li>
                    </ul>

                    <strong><i class="fas fa-users mr-1"></i> Tutor</strong>
                    <p class="text-muted">
                        {{ $estudiante->padre?->Nombre_o_Tutor }} {{ $estudiante->padre?->Apellido }}
                    </p>
                    <hr>
                    <strong><i class="fas fa-calendar-alt mr-1"></i> Nacimiento</strong>
                    <p class="text-muted">{{ $estudiante->Fecha_N }}</p>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('estudiantes.index') }}" class="btn btn-sm btn-block btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-sm btn-block btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: TABLA DE HISTORIAL --}}
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i> 
                        Historial de Matrículas
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Grado/Nivel</th>
                                    <th>Sección</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($estudiante->matriculas as $matricula)
                                    <tr>
                                        <td><span class="badge badge-secondary">#{{ $matricula->id }}</span></td>
                                        <td>{{ $matricula->fecha_matricula }}</td>
                                        <td><strong>{{ $matricula->grupos->Grados->Nombre }}</strong></td>
                                        <td>{{ $matricula->grupos->Descripcion }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('matriculas.show', $matricula->id) }}" class="btn btn-xs btn-outline-info">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fas fa-info-circle mr-1"></i> 
                                            Sin registros de matrícula actualmente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            {{-- Puedes agregar aquí otro card pequeño para estadísticas o notas rápidas --}}
        </div>
    </div>
</div>
@stop
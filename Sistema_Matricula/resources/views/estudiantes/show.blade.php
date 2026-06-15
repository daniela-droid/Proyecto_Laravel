@extends('adminlte::page')

@section('title', 'Detalle del Estudiante')

@section('css')
<style>
    .student-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.75rem;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.06);
    }

    .student-panel h2,
    .student-panel h3 {
        margin-bottom: 0.35rem;
        font-weight: 700;
    }

    .student-panel p,
    .student-panel dd {
        color: #475569;
        margin-bottom: 1rem;
    }

    .student-panel dt {
        font-weight: 600;
        color: #334155;
    }

    .student-panel .avatar-circle {
        width: 82px;
        height: 82px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #1d4ed8;
        margin-bottom: 1rem;
    }

    .student-panel .actions a {
        border-radius: 999px;
        padding: 0.7rem 1.2rem;
        font-weight: 600;
    }

    .student-panel table {
        border-collapse: collapse;
        width: 100%;
    }

    .student-panel th,
    .student-panel td {
        border-bottom: 1px solid #e2e8f0;
        padding: 0.95rem 0.75rem;
        vertical-align: middle;
        color: #334155;
    }

    .student-panel thead th {
        border-bottom: 2px solid #cbd5e1;
        color: #0f172a;
        font-weight: 700;
    }

    .student-panel tbody tr:hover {
        background: #f8fafc;
    }

    .student-panel .table-empty {
        color: #83b0f0;
        text-align: center;
        padding: 2rem 0;
    }
</style>
@stop

@section('content_header')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h1 class="mb-1">Perfil del Estudiante</h1>
      
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row gx-4 gy-4">
        <div class="col-lg-4">
            <section class="student-panel">
                <div class="text-center mb-4">
                    <div class="avatar-circle mx-auto">
                        <i class="fas fa-user-graduate fa-lg"></i>
                    </div>
                    <h2>{{ $estudiante->Nombre }} {{ $estudiante->Apellido }}</h2>
                    <p class="text-muted">Código único: {{ $estudiante->Código_Persona }}</p>
                    <p class="text-muted">Código Temporal: {{ $estudiante->c_temporal }}</p>
                </div>

                <dl>
                    <dt>Sexo</dt>
                    <dd>{{ $estudiante->Sexo }}</dd>

                    <dt>Edad</dt>
                    <dd>{{ $estudiante->edad }} años</dd>

                    <dt>Celular</dt>
                    <dd>{{ $estudiante->Celular }}</dd>

                    <dt>Comarca</dt>
                    <dd>{{ $estudiante->comarca->Comarca ?? 'Sin comarca registrada' }}</dd>

                    <dt>Tutor</dt>
                    <dd>{{ $estudiante->padre?->Nombre_o_Tutor ?? 'No asignado' }} {{ $estudiante->padre?->Apellido ?? '' }}</dd>

                    <dt>Nacimiento</dt>
                    <dd>{{ $estudiante->Fecha_N }}</dd>
                </dl>

                <div class="d-flex gap-2 actions mt-4">
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary w-100">
                        Volver
                    </a>
                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-primary w-100">
                        Editar
                    </a>
                </div>
            </section>
        </div>

        <div class="col-lg-8 ">
            <section class="student-panel">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="mb-1">Historial de Matrículas</h3>
                        <p class="text-muted mb-0">Últimas inscripciones del estudiante.</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Grado</th>
                                <th>Sección</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($estudiante->matriculas as $matricula)
                                <tr>
                                    <td>#{{ $matricula->id }}</td>
                                    <td>{{ $matricula->fecha_matricula }}</td>
                                    <td>{{ $matricula->grupos->Grados->Nombre ?? 'N/D' }}</td>
                                    <td>{{ $matricula->grupos->Descripcion ?? 'N/D' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('matriculas.show', $matricula->id) }}" class="btn btn-sm btn-outline-primary">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="table-empty">
                                        No hay registros de matrícula actualmente.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@stop
@extends('adminlte::page')

@section('title', 'Solicitudes de Notas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="font-weight-bold text-navy">
            <i class="fas fa-bell mr-2"></i>Solicitudes de Corrección de Notas
        </h4>
        <a href="{{ route('notas.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Volver a notas
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card card-outline card-primary shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Docente</th>
                            <th>Estudiante</th>
                            <th>Clase</th>
                            <th>Nota actual</th>
                            <th>Solicitud</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($solicitudes as $solicitud)
                            @php
                                $nota = $solicitud->nota;
                                $estudiante = $nota?->matriculas?->estudiantes;
                                $horario = $nota?->horarios;
                            @endphp
                            <tr>
                                <td>
                                    <div class="font-weight-bold">{{ $solicitud->docente?->Nombre }} {{ $solicitud->docente?->Apellido }}</div>
                                    <small class="text-muted">{{ $solicitud->created_at?->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <div>{{ $estudiante?->Nombre }} {{ $estudiante?->Apellido }}</div>
                                    <small class="text-muted">ID: {{ $estudiante?->Código_Persona }}</small>
                                </td>
                                <td>
                                    <div>{{ $horario?->asignatura?->Nombre ?? 'Sin asignatura' }}</div>
                                    <small class="text-muted">
                                        {{ $horario?->grupo?->grados?->Nombre ?? 'Sin grado' }}
                                        {{ $horario?->grupo?->Nombre ?? '' }}
                                        | {{ $nota?->cortes?->nombre ?? 'Sin corte' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $nota?->nota_normal }}</span>
                                    @if($solicitud->nota_sugerida !== null)
                                        <small class="d-block text-muted">Sugiere: {{ $solicitud->nota_sugerida }}</small>
                                    @endif
                                </td>
                                <td style="max-width: 280px;">
                                    <div>{{ $solicitud->motivo }}</div>
                                    @if($solicitud->respuesta_admin)
                                        <small class="text-muted d-block mt-1">Respuesta: {{ $solicitud->respuesta_admin }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($solicitud->estado === 'pendiente')
                                        <span class="badge badge-warning">Pendiente</span>
                                    @elseif($solicitud->estado === 'aprobada')
                                        <span class="badge badge-success">Aprobada</span>
                                        <small class="d-block text-muted">Hasta {{ $solicitud->aprobada_hasta?->format('d/m/Y') }}</small>
                                    @elseif($solicitud->estado === 'usada')
                                        <span class="badge badge-info">Usada</span>
                                    @else
                                        <span class="badge badge-danger">Rechazada</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($solicitud->estado === 'pendiente')
                                        <form action="{{ route('admin.solicitudes-notas.aprobar', $solicitud) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="respuesta_admin" value="Autorizado para corregir una vez.">
                                            <button class="btn btn-xs btn-success">
                                                <i class="fas fa-check mr-1"></i>Aprobar
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.solicitudes-notas.rechazar', $solicitud) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="respuesta_admin" value="Solicitud rechazada por administración.">
                                            <button class="btn btn-xs btn-danger">
                                                <i class="fas fa-times mr-1"></i>Rechazar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">Atendida</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    No hay solicitudes de corrección registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

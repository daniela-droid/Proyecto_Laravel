@extends('adminlte::page')

@section('title', 'Reporte de calificaciones del corte')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="font-weight-bold text-navy">Reporte de calificaciones del corte</h4>
            <p class="mb-0 text-muted">Grado: <strong>{{ $grado->Nombre }}</strong> · Corte: <strong>{{ $corte->nombre }}</strong></p>
        </div>
        <div class="text-right">
            <img src="{{ asset('img/reportes/Slogan 2026.png') }}" alt="Logo" style="height: 80px; object-fit: contain;" onerror="this.style.display='none'">
        </div>
        <div>
            <a href="{{ route('notas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
            <button class="btn btn-primary" onclick="window.print();">
                <i class="fas fa-print mr-1"></i> Imprimir
            </button>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-outline card-navy shadow">
        <div class="card-body">
            <div class="mb-4">
                <p class="mb-1"><strong>Grado:</strong> {{ $grado->Nombre }}</p>
                <p class="mb-1"><strong>Corte:</strong> {{ $corte->nombre }}</p>
                <p class="mb-0"><strong>Docente:</strong> {{ $docente }}</p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="bg-light text-center">
                        <tr>
                            <th class="align-middle">Código</th>
                            <th class="align-middle">Estudiante</th>
                            @foreach($asignaturas as $asignatura)
                                <th class="align-middle">{{ $asignatura->asignatura->Nombre }}</th>
                            @endforeach
                            <th class="align-middle">Promedio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($filas as $fila)
                            <tr>
                                <td class="align-middle text-center">{{ $fila['codigo'] }}</td>
                                <td class="align-middle">{{ $fila['estudiante'] }}</td>
                                @foreach($fila['notas'] as $nota)
                                    <td class="align-middle text-center">
                                        {{ $nota['display'] ?? '' }}
                                    </td>
                                @endforeach
                                <td class="align-middle text-center font-weight-bold">
                                    {{ $fila['promedio'] !== null ? number_format($fila['promedio'], 2, '.', '') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 2 + $asignaturas->count() + 1 }}" class="text-center text-muted py-4">
                                    No hay datos para el grado y corte seleccionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        @media print {
            .btn, .content-header .btn, .sidebar, .main-sidebar, .main-footer {
                display: none !important;
            }
            .content-header, .content {
                margin: 0;
                padding: 0;
            }
            table {
                page-break-inside: avoid;
            }
        }
    </style>
@stop

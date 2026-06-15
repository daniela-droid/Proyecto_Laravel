@extends('adminlte::page')

@section('title', 'Control de Notas')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="font-weight-bold text-navy">Historial Académico</h4>
        
        <a href="{{ route('notas.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle mr-1"></i> Agregar Notas
        </a>
        
    </div>
@stop

@section('content')
<hr>
   
        <div class="input-group input-group-sl" style="width: 620px;">
             <input type="text" id="buscadorInput" class="form-control buscador-simple" placeholder="Buscar por Nombre o Apellido...">
                <button class="btn btn-secondary limpiar-simple" id="btnLimpiar">
                    <i class="fas fa-times"></i>
                </button>
         </div>
    <div class="row">
        
        {{-- COLUMNA IZQUIERDA: LISTA DE ESTUDIANTES --}}
        <div class="col-md-7">

            <div class="card card-outline card-navy shadow">
                <div class="card-header text-center">
                    <h3  class="card-title text-sm font-weight-bold ">Lista de Estudiantes y Notas</h3>

                </div>
                <div>
                    
                </div>
                <div class="card-body p-0">
                    @if($notasPorGrado->isNotEmpty())
                        <div class="accordion" id="notasPorGradoAccordion">
                            @foreach($notasPorGrado as $grado => $matriculasGrado)
                                @php
                                    $collapseId = 'collapse-' . str_replace(' ', '-', $grado) . '-' . $loop->index;
                                    $estudiantesValidos = $matriculasGrado->filter(function($datosAlumno) {
                                        return $datosAlumno['matricula']->estudiantes;
                                    })->count();
                                @endphp
                                @if($estudiantesValidos > 0)
                                    <div class="card grade-card mb-3">
                                        <div class="card-header bg-navy text-white py-2 d-flex align-items-center">
                                            <button class="btn btn-link text-left text-white font-weight-bold mb-0 flex-grow-1 d-flex justify-content-between align-items-center collapsed" type="button" data-toggle="collapse" data-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">
                                                <span><i class="fas fa-chevron-right mr-2"></i> Grado: {{ $grado }} ({{ $estudiantesValidos }} estudiantes)</span>
                                                <span class="small text-white-50">Mostrar / ocultar</span>
                                            </button>
                                            <button type="button" class="btn btn-light btn-sm ml-2 btn-reporte-grado" data-grado="{{ $grado }}">
                                                <i class="fas fa-print mr-1"></i> Reporte
                                            </button>
                                        </div>
                                        <div id="{{ $collapseId }}" class="collapse">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-sm mb-0 tabla-grado" data-page-size="10">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th>Estudiante</th>
                                                                <th>Grado/Sección</th>
                                                                <th>Última Materia</th>
                                                                <th>Corte</th>
                                                                <th class="text-center">Notas</th>
                                                                <th class="text-right" style="padding-right: 15px">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($matriculasGrado as $id_matricula => $datosAlumno)
                                                                @php
                                                                    $matricula = $datosAlumno['matricula'];
                                                                    $notasAlumno = $datosAlumno['notas'];
                                                                    $ultimaNota = $notasAlumno->first();
                                                                    $est = $matricula->estudiantes;
                                                                    $grupo = $matricula->grupos;
                                                                @endphp
                                                                @if($est)
                                                                    <tr class="data-row">
                                                                        <td class="pl-3">
                                                                            <div class="font-weight-bold text-sm text-navy">{{ $est->Nombre }}</div>
                                                                            <small class="text-muted">ID: {{ $est->Código_Persona }}</small>
                                                                        </td>
                                                                        <td>
                                                                            <div class="text-sm">{{ $grado }}</div>
                                                                            <small class="text-muted">{{ $grupo?->Nombre ?? 'Sin grupo' }}</small>
                                                                        </td>
                                                                        <td>{{ $ultimaNota?->horarios?->asignatura?->Nombre ?? 'Sin notas' }}</td>
                                                                        <td>{{ $ultimaNota?->cortes?->nombre ?? 'Sin notas' }}</td>
                                                                        <td class="text-center">{{ $notasAlumno->count() }}</td>
                                                                        <td class="text-right text-nowrap acciones-col">
                                                                            <button class="btn btn-xs btn-info btn-ver-detalles" 
                                                                                    data-nombre="{{ trim($est->Nombre . ' ' . $est->Apellido) }}"
                                                                                    data-id-matricula="{{ $id_matricula }}">
                                                                                <i class="fas fa-history mr-1"></i>Notas
                                                                            </button>
                                                                            {{-- La edición individual se hace desde el panel de detalle, cuando ya existe una nota. --}}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="grade-pagination px-3 py-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-user-graduate fa-3x mb-3 opacity-50"></i>
                    <p>No hay estudiantes matriculados para mostrar.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: PANEL DE DETALLE FIJO --}}
        <div class="col-md-5">
            <div id="panelDetalle" class="sticky-top" style="top: 20px;">
                <div class="card card-primary card-outline shadow">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-sm text-primary">
                            <i class="fas fa-file-invoice mr-2"></i> DETALLE DE CALIFICACIONES
                        </h3>
                    </div>
                    <div class="card-body" id="contenidoDetalle">
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-user-grad fa-3x mb-3 opacity-50"></i>
                            <p>Seleccione un estudiante de la lista para visualizar su historial completo y observaciones.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('css/notas/index.css') }}">
@stop



@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
    window.NotasIndex = {
        reportesPorGrado: @json($reportesPorGrado),
        nombreCentro: @json($nombreCentro ?: 'Centro educativo no especificado'),
        csrfToken: @json(csrf_token()),
        notasCreateUrl: @json(route('notas.create')),
        sloganUrl: @json(asset('img/reportes/Slogan 2026.png'))
    };
</script>
<script src="{{ asset('js/notas/calificaciones.js') }}"></script>
<script src="{{ asset('js/notas/reportes.js') }}"></script>
<script src="{{ asset('js/notas/historial.js') }}"></script>
<script src="{{ asset('js/notas/tablas.js') }}"></script>
<script src="{{ asset('js/notas/index.js') }}"></script>

{{-- MODALES DE ELIMINACIÓN --}}
@foreach($notasPorGrado as $grado => $notasPorMatricula)
    @foreach($notasPorMatricula as $id_matricula => $datosAlumno)
        @foreach($datosAlumno['notas'] as $nota)
            @if($nota->matriculas?->estudiantes && $nota->horarios?->asignatura)
                <x-delete-modal 
                    id="modalDelete-{{ $nota->id }}" 
                    :route="route('notas.destroy', $nota->id)" 
                    :message="'¿Eliminar calificación de ' . ($nota->horarios->asignatura->Nombre ?? 'Sin asignatura') . ' para ' . $nota->matriculas->estudiantes->Nombre . '?'"
                />
            @endif
        @endforeach
    @endforeach
@endforeach

@stop

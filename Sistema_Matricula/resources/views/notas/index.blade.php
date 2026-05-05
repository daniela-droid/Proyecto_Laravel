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
                            @foreach($notasPorGrado as $grado => $notasPorMatricula)
                                @php
                                    $collapseId = 'collapse-' . str_replace(' ', '-', $grado) . '-' . $loop->index;
                                    $estudiantesValidos = $notasPorMatricula->filter(function($notasAlumno) {
                                        $ultimaNota = $notasAlumno->first();
                                        return $ultimaNota->matriculas?->estudiantes;
                                    })->count();
                                @endphp
                                @if($estudiantesValidos > 0)
                                    <div class="card grade-card mb-3">
                                        <div class="card-header bg-secondary text-white py-2">
                                            <button class="btn btn-link text-left text-white font-weight-bold mb-0 w-100 d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#{{ $collapseId }}" aria-expanded="true" aria-controls="{{ $collapseId }}">
                                                <span><i class="fas fa-chevron-down mr-2"></i> Grado: {{ $grado }} ({{ $estudiantesValidos }} estudiantes)</span>
                                                <span class="small text-white-50">Mostrar / ocultar</span>
                                            </button>
                                        </div>
                                        <div id="{{ $collapseId }}" class="collapse show">
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
                                                            @foreach($notasPorMatricula as $id_matricula => $notasAlumno)
                                                                @php
                                                                    $ultimaNota = $notasAlumno->first();
                                                                    $est = $ultimaNota->matriculas?->estudiantes;
                                                                    $grupo = $ultimaNota->horarios?->grupo;
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
                                                                        <td>{{ $ultimaNota->horarios?->asignatura?->Nombre ?? 'Sin asignatura' }}</td>
                                                                        <td>{{ $ultimaNota->cortes?->nombre ?? 'Sin corte' }}</td>
                                                                        <td class="text-center">{{ $notasAlumno->count() }}</td>
                                                                        <td class="text-right text-nowrap acciones-col">
                                                                            <button class="btn btn-xs btn-info btn-ver-detalles" 
                                                                                    data-nombre="{{ $est->Nombre }}"
                                                                                    data-id-matricula="{{ $id_matricula }}">
                                                                                <i class="fas fa-history mr-1"></i>Notas
                                                                            </button>
                                                                            <!-- <a href="{{ route('notas.edit', $ultimaNota->id) }}" class="btn btn-xs btn-warning">
                                                                                <i class="fas fa-edit mr-1"></i> Editar
                                                                            </a> -->
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
                            <p>No hay estudiantes con notas registradas aún.</p>
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
<style>
    .bg-navy { background-color: #001f3f; color: white; }
    .text-navy { color: #001f3f; }
    .table-xs td { padding: 0.2rem; font-size: 0.85rem; }
    .sticky-top { z-index: 1020; }
.input-group-sm  {
     width: 350px !important;
  
}
  .buscador-simple {
    
    border-right: none !important;
}
.limpiar-simple {

    border-left: none !important;
    padding: 0.25rem 0.5rem !important; /* Mismo tamaño input */
    font-size: 0.875rem !important;
}
.limpiar-simple:hover {
       background: #dc3545 !important;
         color: white !important;
}

    /* Ajustes para la columna de acciones en el índice de notas */
    .grade-card th:last-child,
    .grade-card td.acciones-col {
        width: 1%;
        white-space: nowrap;
    }

    .grade-card .btn-ver-detalles,
    .grade-card .btn-warning {
        padding: 0.2rem 0.5rem !important;
        min-width: 0;
        white-space: nowrap;
    }

    .grade-card .btn-ver-detalles i,
    .grade-card .btn-warning i {
        margin-right: 0.25rem;
    }

</style>
@stop


@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>

    
$(document).ready(function() {
    $(document).on('click', '.btn-ver-detalles', function() {
        const nombre = $(this).data('nombre');
        const idMatricula = $(this).data('id-matricula');
        $('#panelDetalle').attr('data-matricula', idMatricula);
        cargarHistorial(idMatricula, nombre);
    });

    function cargarHistorial(idMatricula, nombre) {
        $('#contenidoDetalle').html(`
            <div class="text-center py-4">
                <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
                <p>Cargando historial de ${nombre}...</p>
            </div>
        `);

        $.ajax({
            url: `/notas/matricula/${idMatricula}/historial`,
            method: 'GET',
            success: function(data) {
                console.log('✅ Datos recibidos:', data);
                
                let filas = '';
                data.notas.forEach(function(n) {
                    // Color según nota_normal
                    let colorNormal = n.nota_normal < 60 ? 'text-danger' : 
                                     n.nota_normal >= 70 ? 'text-success' : 'text-warning';
                    
                    // Nota a mostrar (prioridad: especial > normal)
                    let notaPrincipal = n.nota_especial || n.nota_normal;
                    let colorPrincipal = n.nota_especial ? 
                        (n.nota_especial < 60 ? 'text-danger' : 'text-success') : 
                        colorNormal;
                    
                    filas += `
                        <tr class="table-hover">
                            <td>
                                <div class="font-weight-bold">${n.horarios.asignatura.Nombre}</div>
                                <small class="badge badge-primary">${n.cortes.nombre}</small>
                                <br><small class="text-muted">${n.created_at}</small>
                            </td>
                            <td class="text-center">
                                <div class="h4 mb-1 ${colorPrincipal} font-weight-bold">${notaPrincipal}</div>
                                ${n.nota_especial ? `<small class="text-muted">Especial</small>` : ''}
                                ${n.nota_normal !== n.nota_especial && n.nota_normal ? 
                                    `<div class="small ${colorNormal}">Normal: ${n.nota_normal}</div>` : ''}
                            </td>
                            <td class="text-right align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a href="/notas/${n.id}/edit" class="btn btn-outline-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-outline-danger btn-delete-ajax" 
                                            data-id="${n.id}" data-materia="${n.horarios.asignatura.Nombre}"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        ${n.observaciones ? `
                        <tr>
                            <td colspan="3" class="bg-light p-2 small">
                                <i class="fas fa-comment-dots text-info mr-1"></i>
                                <em>${n.observaciones}</em>
                            </td>
                        </tr>` : ''}
                    `;
                });

                const html = `
                    <div class="mb-3 pb-2 border-bottom">
                        <h5 class="text-navy font-weight-bold mb-1">${nombre}</h5>
                        <span class="badge badge-success">${data.count} calificaciones registradas</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Materia / Corte</th>
                                    <th class="text-center">Calificación</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>${filas}</tbody>
                        </table>
                    </div>
                    <div class="mt-3 text-right">
                        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-print mr-1"></i>Imprimir expediente
                        </button>
                    </div>
                `;
                
                $('#contenidoDetalle').html(html);
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                $('#contenidoDetalle').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Error: ${xhr.status} - ${xhr.statusText}
                    </div>
                `);
            }
        });
    }

    // Delete AJAX
    $(document).on('click', '.btn-delete-ajax', function() {
        const notaId = $(this).data('id');
        $('#modalDelete-' + notaId).modal('show');
    });
});
</script>

<script>
    (function() {
        const initGradeTables = () => {
            const buscador = $('#buscadorInput');
            const limpiar = $('#btnLimpiar');
            const dataTables = [];

            if (!($.fn.DataTable || $.fn.dataTable)) {
                return;
            }

            $('.tabla-grado').each(function() {
                const table = $(this).DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    info: false,
                    searching: true,
                    ordering: false,
                    paging: true,
                    dom: 'tp',
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                    }
                });
                dataTables.push({
                    table,
                    card: $(this).closest('.grade-card')
                });
            });

            const refreshCards = () => {
                const texto = buscador.val().toLowerCase().trim();

                dataTables.forEach(({ table, card }) => {
                    table.search(texto).draw();
                    const visibleRows = table.rows({ filter: 'applied' }).data().length;
                    card.toggle(visibleRows > 0);
                });
            };

            buscador.on('input', refreshCards);
            limpiar.on('click', function() {
                buscador.val('');
                refreshCards();
            });

            refreshCards();
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initGradeTables);
        } else {
            initGradeTables();
        }
    })();
</script>

{{-- MODALES DE ELIMINACIÓN --}}
@foreach($notasPorGrado as $grado => $notasPorMatricula)
    @foreach($notasPorMatricula as $id_matricula => $notasAlumno)
        @foreach($notasAlumno as $nota)
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

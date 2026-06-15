@extends('adminlte::page')

@section('title', 'Horarios')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css">

    <style>
        .filters-panel {
            border: 1px solid #e3e8ef;
            border-radius: 8px;
            background: #f8fbfd;
            padding: 1rem;
        }

        .compact-table th,
        .compact-table td {
            white-space: nowrap;
            vertical-align: middle;
        }

        .compact-table td {
            max-width: 190px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #tableWrapper,
        .compact-table td.actions-cell {
            overflow: visible;
        }

        .compact-table td.actions-cell {
            max-width: none;
        }

        .empty-state {
            min-height: 240px;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            background: #fbfdff;
        }

        .actions-dropdown .btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .actions-dropdown .dropdown-menu {
            min-width: 145px;
            border-radius: 8px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .12);
            z-index: 2050;
        }

        .actions-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: .55rem;
            font-size: .9rem;
        }

        table.dataTable thead .sorting::after,
        table.dataTable thead .sorting::before,
        table.dataTable thead .sorting_asc::after,
        table.dataTable thead .sorting_asc::before,
        table.dataTable thead .sorting_desc::after,
        table.dataTable thead .sorting_desc::before {
            display: none !important;
        }

        #table1 thead th {
            background-color: #b8dffc !important;
            color: #333 !important;
            border-bottom: 2px solid #dee2e6;
            cursor: default !important;
        }

        table.dataTable thead th {
            padding-right: 10px !important;
        }
    </style>
@stop

@section('content_header')
    <h4><strong>Listado de Horarios </strong><i class="fas fa-calendar text-navy"></i></h4>
@stop

@section('content')
    @php
        $grupos = $horarios
            ->filter(fn ($horario) => $horario->grupo)
            ->unique('id_grupo')
            ->sortBy(fn ($horario) => ($horario->grupo->grados->Nombre ?? '') . ' ' . ($horario->grupo->Descripcion ?? ''));

        $docentes = $horarios
            ->filter(fn ($horario) => $horario->docente)
            ->unique('id_docente')
            ->sortBy(fn ($horario) => trim(($horario->docente->Nombre ?? '') . ' ' . ($horario->docente->Apellido ?? '')));

        $formatTime = fn ($time) => $time ? substr($time, 0, 5) : '';

        $horariosData = $horarios->map(function ($horario) use ($formatTime) {
            $grado = $horario->grupo->grados->Nombre ?? '';
            $seccion = $horario->grupo->Descripcion ?? '';
            $grupo = trim($grado . ($seccion ? ' - ' . $seccion : '')) ?: 'Sin grupo';
            $docente = trim(($horario->docente->Nombre ?? '') . ' ' . ($horario->docente->Apellido ?? '')) ?: 'Sin docente';
            $horas = trim($formatTime($horario->Hora_inicio) . ' - ' . $formatTime($horario->Hora_fin), ' -');
            $bloqueHorario = trim(($horario->Dia_semana ?? '') . ($horas ? ' | ' . $horas : ''));

            $acciones = '
                <div class="dropdown actions-dropdown">
                    <button class="btn btn-sm btn-default shadow-sm" type="button" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" title="Acciones">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item text-teal" href="' . route('horarios.show', $horario->id) . '">
                            <i class="fa fa-eye"></i> Ver
                        </a>
                        <a class="dropdown-item text-primary" href="' . route('horarios.edit', $horario->id) . '">
                            <i class="fa fa-pen"></i> Editar
                        </a>
                        <button class="dropdown-item text-danger" type="button" data-toggle="modal" data-target="#modalDelete-' . $horario->id . '">
                            <i class="fa fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>';

            return [
                'grupo_id' => (string) $horario->id_grupo,
                'docente_id' => (string) $horario->id_docente,
                'modalidad' => $horario->grupo->grados->tipo_nivel ?? '',
                'grupo' => $grupo,
                'asignatura' => $horario->asignatura->Nombre ?? '',
                'docente' => $docente,
                'aula' => $horario->aula->Nombre ?? '',
                'horario' => $bloqueHorario,
                'acciones' => $acciones,
            ];
        })->values();
    @endphp

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <a href="{{ route('horarios.create') }}" style="background-color:#233858" class="btn btn-success">
                    <i class="fas fa-plus"></i> Agregar
                </a>
            </div>

            <div class="filters-panel mb-3">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="filterGrupo" class="form-label mb-1">Filtrar por Grado y Sección</label>
                        <select id="filterGrupo" class="form-control">
                            <option value="">Seleccione un grado y sección</option>
                            @foreach ($grupos as $horario)
                                @php
                                    $grado = $horario->grupo->grados->Nombre ?? 'Sin grado';
                                    $seccion = $horario->grupo->Descripcion ?? 'Sin sección';
                                @endphp
                                <option value="{{ $horario->id_grupo }}">{{ $grado }} - {{ $seccion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="filterDocente" class="form-label mb-1">Filtrar por Docente</label>
                        <select id="filterDocente" class="form-control">
                            <option value="">Seleccione un docente</option>
                            @foreach ($docentes as $horario)
                                @php
                                    $nombreDocente = trim(($horario->docente->Nombre ?? '') . ' ' . ($horario->docente->Apellido ?? '')) ?: 'Sin docente';
                                @endphp
                                <option value="{{ $horario->id_docente }}">{{ $nombreDocente }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" id="clearFilters" class="btn btn-outline-secondary w-100">
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>

            <div id="emptyState" class="empty-state">
                <div>
                    <i class="fas fa-filter fa-2x mb-3 text-info"></i>
                    <p class="mb-0">Por favor, seleccione un Grado o un Docente para visualizar los horarios asignados</p>
                </div>
            </div>

            <div id="tableWrapper" class="table-responsive d-none">
                <table id="table1" class="table table-striped table-hover compact-table w-100">
                    <thead>
                        <tr>
                            <th>Modalidad</th>
                            <th>Grupo</th>
                            <th>Asignatura</th>
                            <th>Docente</th>
                            <th>Aula</th>
                            <th>Horario</th>
                            <th style="width: 5%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            @foreach ($horarios as $horario)
                <x-delete-modal
                    id="modalDelete-{{ $horario->id }}"
                    :route="route('horarios.destroy', $horario->id)"
                    :message="'¿Seguro que deseas eliminar el horario con el id ' . $horario->id . '?'"/>
            @endforeach
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            const horarios = @json($horariosData);
            const emptyState = $('#emptyState');
            const tableWrapper = $('#tableWrapper');

            const table = $('#table1').DataTable({
                data: [],
                ordering: false,
                pageLength: 10,
                lengthChange: false,
                language: {
                    search: 'Buscar:',
                    zeroRecords: 'No se encontraron horarios para los filtros seleccionados.',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ horarios',
                    infoEmpty: 'Sin horarios para mostrar',
                    paginate: {
                        first: 'Primero',
                        last: 'Último',
                        next: 'Siguiente',
                        previous: 'Anterior'
                    }
                },
                columns: [
                    { data: 'modalidad' },
                    { data: 'grupo' },
                    { data: 'asignatura' },
                    { data: 'docente' },
                    { data: 'aula' },
                    { data: 'horario' },
                    { data: 'acciones', orderable: false, searchable: false, className: 'actions-cell text-center' }
                ]
            });

            function applyFilters() {
                const grupoId = $('#filterGrupo').val();
                const docenteId = $('#filterDocente').val();
                const hasFilters = grupoId || docenteId;

                if (!hasFilters) {
                    table.clear().draw();
                    tableWrapper.addClass('d-none');
                    emptyState.removeClass('d-none');
                    return;
                }

                const filteredRows = horarios.filter(function(horario) {
                    const matchesGrupo = !grupoId || horario.grupo_id === grupoId;
                    const matchesDocente = !docenteId || horario.docente_id === docenteId;
                    return matchesGrupo && matchesDocente;
                });

                emptyState.addClass('d-none');
                tableWrapper.removeClass('d-none');
                table.clear().rows.add(filteredRows).draw();
                table.columns.adjust();
            }

            $('#filterGrupo, #filterDocente').on('change', applyFilters);

            $('#clearFilters').on('click', function() {
                $('#filterGrupo, #filterDocente').val('');
                applyFilters();
            });
        });
    </script>
@stop

@extends('adminlte::page')

@section('title', 'Reportes')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <!-- Estilos de DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<style>
    /* 1. Redondeamos la tarjeta principal */
    .card {
        border-radius: 15px !important;
        overflow: hidden;
    }

    /* 2. Estilo moderno para la cabecera (Sin bordes toscos) */
    #table1 thead th {
        background-color: #f1f4f8; /* Un gris-azul muy suave */
        border: none;
        color: #555;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        padding: 15px;
    }

    /* 3. Redondear las esquinas de la tabla */
    #table1 {
        border-radius: 12px;
        overflow: hidden;
        border-collapse: separate !important;
        border-spacing: 0;
    }

    /* 4. Suavizar las filas */
    #table1 tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa; /* Línea separadora muy sutil */
        color: #666;
    }

    /* 5. Efecto al pasar el mouse */
    #table1 tbody tr:hover {
        background-color: #f9fbff !important; /* Azul casi blanco */
        transition: 0.3s;
    }

    /* 6. Quitar el borde feo del buscador y botones */
    .dataTables_filter input {
        border-radius: 20px !important;
        border: 1px solid #ddd !important;
        padding: 5px 15px !important;
    }
</style>
    @stop

@section('content_header')
<!-- <div style="background-color:#233858; color: white; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem; ">Gestión de Reportes Administrativos</h1>
</div> -->
<h4><strong>Reportes </strong><i class="fas fa-chart-line text-navy"></i></h4>
@stop

@section('content')
<a href="{{ route('reportesadm.create') }}" class="btn btn-primary mb-3 shadow">
    <i class="fas fa-plus"></i> Agregar
</a>

<div class="container-fluid">
    @php  
        $heads = [
            'ID',
            'Admin', 
            'Título',
            'Descripción',
            'Categoría',
            ['label' => 'Acciones', 'no-export' => true, 'width' => 10],
        ];

        $data = [];
        foreach($reportesadm as $reporte) {
            // Colores dinámicos para categorías
            $badgeColor = match($reporte->categoria) {
                'tecnico' => 'danger',
                'academico' => 'info',
                'disciplinario' => 'warning',
                default => 'secondary',
            };
            
            $categoriaBadge = '<span class="badge badge-'.$badgeColor.'">'.ucfirst($reporte->categoria).'</span>';

            $btnEdit = '<a href="' . route('reportesadm.edit', $reporte->id) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal" data-target="#modalDelete-'.$reporte->id.'" title="Eliminar"><i class="fa fa-lg fa-fw fa-trash"></i></button>';
           $btnPdf = '<a href="' . route('reportes.pdf', ['tipo' => 'admin', 'id' => $reporte->id]) . '" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Bajar PDF">
            <i class="fa fa-lg fa-fw fa-file-pdf"></i>
           </a>';

            $data[] = [ 
                $reporte->id,
                $reporte->id_admin,
                "<b>$reporte->titulo</b>",
                Str::limit($reporte->descripcion, 50), // Limitar texto largo
                $categoriaBadge,       
                '<nobr>'.$btnPdf.$btnEdit.$btnDelete.'</nobr>'                    
            ];
        }

        $config = [
            'data' => $data,
            'order' => [[0, 'desc']],
            'language' => ['url' => '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'],
        ];
    @endphp
            <x-adminlte-card class="shadow-sm border-0 rounded-lg">
                <!-- Título más elegante -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-secondary font-weight-bold mb-0">
                        <i class="fas fa-file-alt mr-2 text-primary"></i>Listado de Reportes
                    </h5>
                </div>

                <div class="table-responsive">
                    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" 
                        hoverable 
                        class="table-hover border-0"
                        style="width:100%">
                    </x-adminlte-datatable>
                </div>
            </x-adminlte-card>


 
    {{-- Modales de eliminación --}}
    @foreach ($reportesadm as $reporte)
        <div class="modal fade" id="modalDelete-{{ $reporte->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form action="{{ route('reportesadm.destroy', $reporte->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white">Confirmar Eliminación</h5>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de eliminar el reporte: <b>{{ $reporte->titulo }}</b>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>
@stop
@section('js')
<script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    

    <!-- Librerías de DataTables y DataTables Buttons -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <!-- Otras librerías necesarias para exportar a PDF y Excel -->
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.jsdelivr.net/npm/pdfmake@0.1.66/build/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.jsdelivr.net/npm/pdfmake@0.1.66/build/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        const triggerTabList = document.querySelectorAll('#myTab button');
        triggerTabList.forEach(triggerEl => {
            const tabTrigger = new bootstrap.Tab(triggerEl);

            triggerEl.addEventListener('click', event => {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    </script>
@stop
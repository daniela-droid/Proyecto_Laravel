@extends('adminlte::page')

@section('title', 'Periodos Academicos')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Estilos de DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css">

<style>
    /*Importante para modificar la tabla*/
    .compact-table th,
   .compact-table td {
    white-space: nowrap;      /* No rompe líneas */
    overflow: hidden;         /* Oculta exceso de texto */
    text-overflow: ellipsis;  /* Muestra "..." si es muy largo */
    vertical-align: middle;
    max-width: 170px;         /* Ajusta  */
 
}

    /* 1. Quita las flechas de ordenamiento de DataTables */
    table.dataTable thead .sorting::after,
    table.dataTable thead .sorting::before,
    table.dataTable thead .sorting_asc::after,
    table.dataTable thead .sorting_asc::before,
    table.dataTable thead .sorting_desc::after,
    table.dataTable thead .sorting_desc::before {
        display: none !important;
    }

    /* 2. Color cielo claro para el encabezado y texto alineado */
    #table1 thead th {
        background-color: #b8dffc !important; /* Azul cielo claro */
        color: #333 !important;              /* Texto oscuro para contraste */
        border-bottom: 2px solid #dee2e6;
        cursor: default !important;          /* Quita la mano de "clic" */
    }

    /* Opcional: ajustar padding para que se vea más limpio sin las flechas */
    table.dataTable thead th {
        padding-right: 10px !important;
    }

</style>
@stop
@section('content_header')

    <!-- Panel superior -->
<!-- <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem;">Periodos</h1>
</div> -->
<h4><strong>Periodos Acádemicos </strong><i class="fa fa-hourglass-half text-navy"></i></h4>
@stop

@section('content')
<div class="card">
        <div class="card-body">
            <a href="{{ route('periodo.create') }}" style="background-color:#233858" class="btn btn-success mb-3">
                <i class="fas fa-plus" theme="blue"></i> Agregar
            </a>
 <!-- Botón Editar -->
<div class="container">
    @php  
        if(count($periodo_academicos)>0){
            $heads = [
          
               'Nombre',
               'Fecha_inicio', 
               'Fecha_fin',  
               'Activo',

                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];
        }else{
            $heads = ['$periodo_academicos'];
        }
            
        if(count($periodo_academicos)>0){
            $data=[];
            foreach($periodo_academicos as $periodo){
                $btnEdit = '<a href="' . route('periodo.edit', $periodo->id) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>';
                $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal" title="Delete" data-target="#modalDelete-'.$periodo->id.'">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>';
                $btnDetails = '<a href="' . route('periodo.show', $periodo->id) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </a>';

                $estado = $periodo->Activo 
                ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Activo</span>' 
                : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactivo</span>';
                $data[] = [ 
                     
                    $periodo->Nombre,     
                    $periodo->Fecha_inicio,
                    $periodo->Fecha_fin,
                    $estado,
                   
                   

                    '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'                    
                ];
            }
        }else{              
            $data[] = ['No hay registros en la tabla.'];
        }

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => (count($periodo_academicos) > 0) ? [null, null, null, null, null, null, ['orderable' => false]] : [['orderable' => false]],
        ];
    @endphp

    {{-- Tabla --}}
    <div class="row">
        <div class="col">
            <hr>
            <!-- <x-adminlte-card icon="fas fa-user-graduate"  theme="lightblue" title="Listado de Periodos"> -->
                <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" theme="light" striped hoverable>
                    @foreach($config['data'] as $row)
                        <tr>
                            @foreach($row as $cell)
                                <td>{!! $cell !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>  
        </div>
    </div>

    {{-- Modales de confirmación --}}
    @foreach ($periodo_academicos  as $periodo)
        <x-delete-modal 
            id="modalDelete-{{ $periodo->id }}"
            :route="route('periodo.destroy', $periodo->id)"
            :message="'¿Seguro que deseas eliminar la modalidad con el id ' . $periodo->id . '?'"/>
    @endforeach

</div>

  
@endsection
@section('js')
    <!-- jQuery ya viene con AdminLTE -->
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function() {
        $('.select-buscable').select2({
            placeholder: "Escribe para buscar...",
            allowClear: true,
            width: '50%' // Para que mantenga el tamaño que definiste en Bootstrap
        });
    });
</script>
@stop
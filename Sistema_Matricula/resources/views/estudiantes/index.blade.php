@extends('adminlte::page')

@section('title', 'Estudiantes')

@section('css')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css"> -->
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
a:hover{
    background-color:#5A94C1 !important;
    color:white;
}
a{
    text-decoration:none !important;
}
#footer{
    background-color:#b8dffc !important;
}
#negra{
    color:black;
}
</style>
@stop

@section('content_header')

    <!-- Panel superior -->

@stop

@section('content')
<div class="card">
            <div style="background-color: #f7f9fc; border-radius: 5px; ">
        <div class="card-body" id="body">
        <div class="container">
    <div class="row">

        <div class="col-md-4 bg-light">
        <div class="card">
            <div class="card-title">
                <div class="card-body text-center">
                    <h4>{{$total_estudiantes ?? 0}}</h4> <div class="icon">
            <!-- Usamos el icono de estudiante que elegimos -->
            <i class="fas fa-user-graduate sm text-primary"></i>
            <h4>Total Estudiantes</h4>
        </div>
         </div>
        </div>
        <div id="footer" class="card-footer text-center ">
          <a id="negra" href="#table">
            Ver listado <i class="fas fa-arrow-circle-right"></i>
        </a>
        </div>
        </div>
        </div>

                <div class="col-md-4 bg-light">
            <div class="card" id="inicio">
                <div class="card-body text-center">
                    <h3>{{ $estudiantesPrimaria->count() }}</h3>
                    <i class="fas fa-child text-primary"></i>
                    <h4>De Primaria</h4>
                </div>
                <div id="footer" class="card-footer text-center">
                    {{-- Se eliminó "route" extra y se cerró la comilla --}}
                    <a id="negra" href="{{ route('estudiantes.primaria') }}"> 
                        Ver listado <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 bg-light">
    <div class="card">
        <div class="card-body text-center">
            <h3>{{ $estudiantesSecundaria->count() }}</h3>
            <i class="fas fa-user text-success"></i>
            <h4>De Secundaria</h4>
        </div>
        <div class="card-footer  text-center" id="footer">
            <a id="negra" href="{{ route('estudiantes.secundaria') }}"> 
                Ver listado <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    </div>


        
</div>
 </div>        

 
        <a href="{{ route('estudiantes.create') }}" style="background-color:#233858" class="btn btn-success mb-3">
        <i class="fas fa-plus" theme="blue"></i> Agregar
        </a>



 <!-- Botón Editar -->
<div id="table" class="container ">
    @php  
        if(count($estudiantes)>0){
            $heads = [
                 'Código de Persona',
                'Nombres', 
                'Apellidos',
                'Sexo',
                'Fecha de Nacimiento',
                'Edad',
                'Celular',
                'Padres',
                'Comarcas',
             ['label' => 'Acciones', 'no-export' => true, 'width' => 10, 'class' => 'text-center'], 
        ];
        }else{
            $heads = ['$estudiantes'];
        }
            
        if(count($estudiantes)>0){
            $data=[];
            foreach($estudiantes as $estudiante){
                $btnEdit = '<a href="' . route('estudiantes.edit', $estudiante->id) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>';
                $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal" title="Delete" data-target="#modalDelete-'.$estudiante->id.'">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>';
                $btnDetails = '<a href="' . route('estudiantes.show', $estudiante->id) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </a>';

                $data[] = [ 
                    $estudiante->Código_Persona,     
                    $estudiante->Nombre, 
                    $estudiante->Apellido,
                    $estudiante->Sexo,
                    $estudiante->Fecha_N,
                    $estudiante->Edad,
                    $estudiante->Celular,
                    $estudiante->padre->Nombre_o_Tutor ?? '', 
                    $estudiante->comarca->Comarca ?? '',
                   

                    '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'                    
                ];
            }
        }else{              
            $data[] = ['No hay registros en la tabla.'];
        }

            $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'pageLength' => 5,
            'lengthMenu' => [5, 10, 20, 50],
            'ordering' => false, // Sin espacio al inicio
            'language' => [
                'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            ],
            'columnDefs' => [
                ['targets' => -1, 'className' => 'text-center'] 
            ],
            // Ajustado a 10 columnas exactas para que coincida con $heads
            'columns' => (count($estudiantes) > 0) 
                ? [null, null, null, null, null, null, null, null, null, ['orderable' => false]] 
                : [['orderable' => false]],
        ];
    @endphp

    {{-- Tabla --}}
    <div class="row">
        <div class="col">
            
            <!-- <x-adminlte-card icon="fas fa-user-graduate"  theme="lightblue" title="Listado de Estudiantes"> -->
                <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" theme="light" :config="$config" striped hoverable>
                    @foreach($config['data'] as $row)
                        <tr>
                            @foreach($row as $cell)
                                <td>{!! $cell !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            <!-- </x-adminlte-card>   -->
        </div>
    </div>

    {{-- Modales de confirmación --}}
    @foreach ($estudiantes as $estudiante)
        <x-delete-modal 
            id="modalDelete-{{ $estudiante->id }}"
            :route="route('estudiantes.destroy', $estudiante->id)"
            :message="'¿Seguro que deseas eliminar la modalidad con el id' . $estudiante->id. '?'"/>
    @endforeach

<!-- tabla estudaintes de secuandaria -->

</div>

  
@endsection
@section('js')
    <!-- jQuery ya viene con AdminLTE -->
    <!-- DataTables -->
    

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/jquery.overlayScrollbars.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function() {
        $('.select-buscable').select2({
            placeholder: "Escribe para buscar...",
            allowClear: true,
            width: '50%' // Para que mantenga el tamaño que definiste en Bootstrap
        });
    });

//   

</script>
@stop
@extends('adminlte::page')

@section('title', 'Matriculas')
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
    max-width: 170px;         /* Ajusta según convenga */
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

<h4><strong>Matriculas </strong><i class="fas fa-file text-navy"></i></h4>

@stop
@section('content')

 <!-- Botón Editar -->
            <a href="{{ route('matriculas.create') }}" style="background-color: #233858;" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Agregar
            </a>

        </div>
    <div class="container">
    @php  
        if(count($matriculas)>0){
            $heads = [
          
                'Estudiantes',  
                'Secciones', 
                'Grado', 
                'Tipo',
                'Periodos Académico', 
                'Fecha de Matricula',
                'Estados',  
                     
                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];
        }else{
            $heads = [
                'matriculas',
            ];
        }
            
            if(count($matriculas)>0){
                $data=[];
                foreach($matriculas as $matricula){
                $estadosDisponibles = ['Activo', 'Retirado', 'Suspendido', 'Expulsado'];
            $selectEstado = '<select class="form-control form-control-sm select-toggle-estado shadow-sm" data-id="' . $matricula->id . '">';

            foreach ($estadosDisponibles as $est) {
                $selected = ($matricula->estado == $est) ? 'selected' : '';
                
                // Opcional: Agregar colores de texto a las opciones para que se vea mejor
                $style = '';
                if ($est == 'Activo') $style = 'style="color: green; font-weight: bold;"';
                if ($est == 'Retirado') $style = 'style="color: gray;"';
                if ($est == 'Suspendido') $style = 'style="color: orange;"';
                if ($est == 'Expulsado') $style = 'style="color: red;"';

                $selectEstado .= '<option value="' . $est . '" ' . $selected . ' ' . $style . '>' . $est . '</option>';
            }
            $selectEstado .= '</select>';


                    $btnEdit = '<a href="' . route('matriculas.edit', $matricula->id) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </a>';
                    $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal" title="Delete" data-target="#modalDelete-' . $matricula->id . '">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>';
                                
                    $btnDetails = '<a href="' . route('matriculas.show', $matricula->id) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </a>';

                    $data[] = [ 
                            
                        $matricula->estudiantes->Nombre ?? '',       
                        $matricula->grupos->Descripcion ?? '' , 
                        $matricula->grupos->grados->Nombre ?? '' ,  
                        $matricula->grupos->grados->tipo_nivel ?? '',
                        $matricula->periodos->Nombre ?? '', 
                        $matricula->fecha_matricula, 
                         $selectEstado,
                               
                        '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'
                            
                    ];
                }
            }else{              
                $data[] = ['No hay registros en la tabla.'];
            }
            $config = [
                'data' => $data,
                'order' => [[1, 'asc']],
                'columns' => (count($matriculas) > 0) ? [null, null, null, null, null, null, null, null,['orderable' => false]] : [['orderable' => false]],
            ];

    @endphp

        <div class="row">
            <div class="col">
                <hr>
                <!-- <x-adminlte-card icon="fas fa-file-alt"  theme="lightblue" title="Listado de Matriculas"> -->
                    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" theme="light" striped hoverable >
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


    </div>

 {{-- confirmación de modals--}}
    @foreach ($matriculas as $matricula)
       <x-delete-modal 
        id="modalDelete-{{ $matricula->id }}"
        :route="route('matriculas.destroy', $matricula->id)"
        :message="'¿Seguro que deseas eliminar la matrícula de ' 
                  "/>
    @endforeach

</div>


@stop

@section('js')
    <!-- jQuery ya viene con AdminLTE -->
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#asignaturasTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                }
            });
        });

    
    </script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Escuchar el cambio del select dentro de tu Datatable de AdminLTE
    document.querySelector('#table1').addEventListener('change', function (e) {
        const target = e.target.closest('.select-toggle-estado');
        if (!target) return;

        const matriculaId = target.getAttribute('data-id');
        const nuevoEstado = target.value;

        // Deshabilitar momentáneamente para evitar que hagan doble clic
        target.disabled = true;

        // Petición al servidor obligando la ruta limpia
        fetch(`/matriculas/${matriculaId}/update-status-only`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ estado: nuevoEstado })
        })
        .then(response => {
            // Si Laravel arroja un error 404, 500 o de validación, enviamos el texto al siguiente paso
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // EXITO: La BD confirmó el guardado, ahora recargamos seguros
                window.location.reload();
            } else {
                alert('El servidor respondió con error: ' + data.message);
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error capturado:', error);
            // Si la ruta no existe o falla la validación, esta alerta te dirá el porqué
            alert('ERROR CRÍTICO: ' + (error.message || 'La ruta /matriculas/' + matriculaId + '/update-status-only no fue encontrada o la validación falló. Revisa tu archivo de rutas.'));
            window.location.reload();
        });
    });
});
</script>
@stop
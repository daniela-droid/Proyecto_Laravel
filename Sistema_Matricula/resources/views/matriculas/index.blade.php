@extends('adminlte::page')

@section('title', 'Matriculas')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <!-- Estilos de DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
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
</style>
    @stop
@section('content_header')

    <!-- Panel superior -->
<div style="background-color: #3f6570ff; color: white; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem;">Matriculas</h1>
</div>

@stop
@section('content')

 <!-- Botón Editar -->
            <a href="{{ route('matriculas.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nueva Matricula
            </a>

        </div>
    <div class="container">
    @php  
        if(count($matriculas)>0){
            $heads = [
                'Id',
                'Id_Estudiantes',  
                'Id_Asignaturas',            
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            ];
        }else{
            $heads = [
                'matriculas',
            ];
        }
            
            if(count($matriculas)>0){
                $data=[];
                foreach($matriculas as $matricula){
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
                        $matricula->id,       
                        $matricula->id_estudiantes,       
                        $matricula->id_asignaturas ,            
                        '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'
                            
                    ];
                }
            }else{              
                $data[] = ['No hay registros en la tabla.'];
            }
            $config = [
                'data' => $data,
                'order' => [[1, 'asc']],
                'columns' => (count($matriculas) > 0) ? [null, null, null, null, ['orderable' => false]] : [['orderable' => false]],
            ];

    @endphp

        {{-- Minimal example / fill data using the component slot --}}
        <div class="row">
            <div class="col">
                <x-adminlte-card icon="fas fa-file-alt"  theme="dark" title="Listado de Matriculas">
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
        :message="'¿Seguro que deseas eliminar la matrícula de <b>' 
                   . $matricula->estudiantes->nombre . '</b> en <b>' 
                   . $matricula->asignaturas->nombre . '</b>?'" />
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
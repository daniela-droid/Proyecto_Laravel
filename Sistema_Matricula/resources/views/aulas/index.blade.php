@extends('adminlte::page')

@section('title', 'Aulas')

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
<div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem;">Aulas</h1>
</div>

@stop

@section('content')

 <!-- Botón Editar -->
           <a href="{{ route('aulas.create') }}" style="background-color:#233858"class="btn btn-success mb-3">
    <i class="fas fa-plus"></i> Nueva Aula o Seccion
</a>

<div class="container">
    @php  
        if(count($aulas)>0){
            $heads = [
                
                'Nombre',
                'Capacidad',
                            
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            ];
        }else{
            $heads = ['aulas'];
        }
            
        if(count($aulas)>0){
            $data=[];
            foreach($aulas as $aula){
                $btnEdit = '<a href="' . route('aulas.edit', $aula->id) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>';
                $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal" title="Delete" data-target="#modalDelete-'.$aula->id.'">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>';
                $btnDetails = '<a href="' . route('aulas.show', $aula->id) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </a>';

                $data[] = [ 
                          
                    $aula->Nombre,
                    $aula->Capacidad,
                                        
                    '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'                    
                ];
            }
        }else{              
            $data[] = ['No hay registros en la tabla.'];
        }

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => (count($aulas) > 0) ? [null, null, null, ['orderable' => false]] : [['orderable' => false]],
        ];
    @endphp

    {{-- Tabla --}}
    <div class="row">
        <div class="col">
            <x-adminlte-card icon="fas fa-book"  theme="lightblue" title="Listado de Aulas">
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
    @foreach ($aulas as $aula)
        <x-delete-modal 
            id="modalDelete-{{ $aula->id }}"
            :route="route('aulas.destroy', $aula->id)"
            :message="'¿Seguro que deseas eliminar la modalidad con el id ' . $aula->id . '?'"/>
    @endforeach

</div>

           
@endsection


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
@stop
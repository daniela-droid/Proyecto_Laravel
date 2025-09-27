@extends('adminlte::page')

@section('title', 'Asignaturas')

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
<div style="background-color: #47b3d4ff; color: dark; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem;">Listado de Asignaturas</h1>
</div>

@stop

@section('content')

 <!-- Botón Editar -->
            <a href="{{ route('asignaturas.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nueva Asignatura
            </a>
        </div>
    <div class="container">
    @php  
        if(count($asignaturas)>0){
            $heads = [
                'Id',
                'Nombre',                
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            ];
        }else{
            $heads = [
                'asignaturas',
            ];
        }
            
            if(count($asignaturas)>0){
                $data=[];
                foreach($asignaturas as $asignatura){
                    $btnEdit = '<a href="' . route('asignaturas.edit', $asignatura->id) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </a>';
                    $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal" title="Delete" data-target="#modalDelete-' . $asignatura->id . '">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>';
                                
                    $btnDetails = '<a href="' . route('asignaturas.show', $asignatura->id) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </a>';

                    $data[] = [ 
                        $asignatura->id,       
                        $asignatura->nombre,                       
                        '<nobr>'.$btnEdit.$btnDetails.'</nobr>'
                            
                    ];
                }
            }else{              
                $data[] = ['No hay registros en la tabla.'];
            }
            $config = [
                'data' => $data,
                'order' => [[1, 'asc']],
                'columns' => (count($asignaturas) > 0) ? [null, null, null, ['orderable' => false]] : [['orderable' => false]],
            ];

    @endphp

        {{-- Minimal example / fill data using the component slot --}}
        <div class="row">
            <div class="col">
                <x-adminlte-card icon="fas fa-cogs"  theme="dark" title="Listado de Servicio">
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

            <div class="container">
             <div class="row">
                <div class="col">
            <table id="tabla-asignaturas"  class="table table-bordered table-striped table-hover table-sm compact-table">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th with=5px;>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($asignaturas as $asignatura)
                        <tr>
                            <td>{{ $asignatura->id }}</td>
                            <td>{{ $asignatura->nombre }}</td>
                            <td>
                                <!-- Boton  de ver -->
                                <a href="{{ route('asignaturas.show', $asignatura->id) }}" 
                                   class="btn btn-info btn-sm">
                                   <i class="fas fa-eye"></i>
                                </a>

                                <!-- Boton  de editar -->
                                <a href="{{ route('asignaturas.edit', $asignatura->id) }}" 
                                   class="btn btn-warning btn-sm">
                                   <i class="fas fa-edit"></i>
                                </a>

                                <!-- Boton de eliminar -->
                                <form action="{{ route('asignaturas.destroy', $asignatura->id) }}" 
                                      method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar esta asignatura?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No hay Asignaturas registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



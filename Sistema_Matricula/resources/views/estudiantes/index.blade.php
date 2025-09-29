@extends('adminlte::page')

@section('title', 'Estudiantes')

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
    <h1 style="margin: 0; font-size: 1.5rem;">Estudiantes</h1>
</div>
@stop

@section('content')
<div class="card">
        <div class="card-body">
            <a href="{{ route('estudiantes.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus" theme="dark"></i> Nuevo Estudiante
            </a>
 <!-- Botón Editar -->
<div class="container">
    @php  
        if(count($estudiantes)>0){
            $heads = [
                'id',
                'nombre', 
                'apellido',
                'sexo',
                'cedula',
                'edad',
                'celular',
                'nombre_madre',
                'nombre_padre',

                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
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
                    $estudiante->id,       
                    $estudiante->nombre, 
                    $estudiante->apellido,
                    $estudiante->sexo,
                    $estudiante->cedula,
                    $estudiante->edad,
                    $estudiante->celular,
                    $estudiante->nombre_madre,
                    $estudiante->nombre_padre,

                    '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'                    
                ];
            }
        }else{              
            $data[] = ['No hay registros en la tabla.'];
        }

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => (count($estudiantes) > 0) ? [null, null, null, null, null, null, null, null, null, null, null, null,['orderable' => false]] : [['orderable' => false]],
        ];
    @endphp

    {{-- Tabla --}}
    <div class="row">
        <div class="col">
            <x-adminlte-card icon="fas fa-user-graduate"  theme="dark" title="Listado de Estudiantes">
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
    @foreach ($estudiantes as $estudiante)
        <x-delete-modal 
            id="modalDelete-{{ $estudiante->id }}"
            :route="route('estudiantes.destroy', $estudiante->id)"
            :message="'¿Seguro que deseas eliminar <b>' . $estudiante->nombre . '</b>?'"/>
    @endforeach

</div>

  
@endsection

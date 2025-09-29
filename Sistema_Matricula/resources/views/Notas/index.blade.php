@extends('adminlte::page')

@section('title', 'Notas')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <!-- Estilos de DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@stop

@section('content_header')
<div style="background-color: #3f6570ff; color: white; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem;">Notas</h1>
</div>
@stop

@section('content')

<!-- Botón Editar -->
           <a href="{{ route('asignaturas.create') }}" class="btn btn-success mb-3">
    <i class="fas fa-plus"></i> Nueva Nota
</a>

<div class="container">
    @php  
        if(count($notas)>0){
            $heads = [
                'Id',
                'Id_Estudiantes', 
                'Id_Asignaturas',
                'Id_usuarios',
                'Notas',       
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            ];
        }else{
            $heads = ['notas'];
        }
            
        if(count($notas)>0){
            $data=[];
            foreach($notas as $nota){
                $btnEdit = '<a href="' . route('notas.edit', $nota->id) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>';
                $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal" title="Delete" data-target="#modalDelete-'.$nota->id.'">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>';
                $btnDetails = '<a href="' . route('notas.show', $nota->id) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </a>';

                $data[] = [ 
                    $nota->id,       
                    $nota->id_estudiantes,
                    $nota->id_asignaturas,
                    $nota->id_usuarios,
                    $nota->notas,                      
                    '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'                    
                ];
            }
        }else{              
            $data[] = ['No hay registros en la tabla.'];
        }

     $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => (count($notas) > 0) ? [null, null, null, null, null, null,  ['orderable' => false]] : [['orderable' => false]],
        ];
    @endphp

    {{-- Tabla --}}
    <div class="row">
        <div class="col">
            <x-adminlte-card icon="fas fa-sticky-note"  theme="dark" title="Listado de Notas">
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
    @foreach ($notas as $nota)
        <x-delete-modal 
            id="modalDelete-{{ $nota->id }}"
            :route="route('notas.destroy', $nota->id)"
            :message="'¿Seguro que deseas eliminar <b>' . $nota->nombre . '</b>?'"/>
    @endforeach

</div>




@stop


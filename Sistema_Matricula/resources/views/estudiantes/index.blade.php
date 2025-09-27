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
  

@section('content')
   <div class="card">
        <div class="card-body">
            <a href="{{ route('estudiantes.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus" theme="dark"></i> Nuevo Estudiante
            </a>

                    <div class="container">
                <div class="row">
                    <div class="col">
                        <x-adminlte-card icon="fas fa-user-graduate" theme="dark" title="Listado de Estudiantes">
                        <div class="table-responsive w-90 mx-auto">
            <table id="tabla-estudiantes" class="table table-bordered table-striped table-hover table-sm compact-table">


                    <thead class="bg-dark text-white">
                        <tr>
                            <th >ID</th>
                            <th >Nombre</th>
                            <th>Apellido</th>
                            <th>Sexo</th>
                            <th>Cédula</th>
                            <th>Edad</th>
                            <th>Celular</th>
                            <th>Nombre Madre</th>
                            <th>Nombre Padre</th>
                            <th>Comarca</th>
                            <th >Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiantes as $estudiante)
                            <tr>
                                <td >{{ $estudiante->id }}</td>
                                <td>{{ $estudiante->nombre }}</td>
                                <td>{{ $estudiante->apellido }}</td>
                                <td>{{ $estudiante->sexo }}</td>
                                <td>{{ $estudiante->cedula }}</td>
                                <td>{{ $estudiante->edad }}</td>
                                <td>{{ $estudiante->celular }}</td>
                                <td>{{ $estudiante->nombre_madre }}</td>
                                <td>{{ $estudiante->nombre_padre }}</td>
                                <td>{{ $estudiante->comarca }}</td>
                                <td>
                                    <!-- Botón Ver -->
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}" 
                                       class="btn btn-xs btn-default text-teal mx-1 shadow" title="Ver">
                                        <i class="fa fa-sm fa-fw fa-eye"></i>
                                    </a>

                                    <!-- Botón Editar -->
                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}" 
                                       class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
                                        <i class="fa fa-sm fa-fw fa-pen"></i>
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('estudiantes.destroy', $estudiante->id) }}" 
                                          method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                                title="Eliminar"
                                                onclick="return confirm('¿Seguro que deseas eliminar este estudiante?')">
                                            <i class="fa fa-sm fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-adminlte-card>
        </div>
    </div>
</div>
@stop
<!--LIBRERIAS IMPORTANTES-->
@section('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabla-estudiantes').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                "pageLength": 5,
                "lengthMenu": [5, 10, 20, 50],
                "order": [[0, "asc"]] // Ordenar por ID
            });
        });
    </script>
@stop

@extends('adminlte::page')
@section('title', 'Estudiantes Primaria')
@section('css')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css"> -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Estilos de DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
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
@section('content')
<div class="card">
<div class="card-body">

 <hr>
        <h4><i class="fas fa-graduation-cap"></i> Estudiantes de Primaria</h4>

        <form method="GET" action="{{ route('estudiantes.primaria') }}" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="grado" class="form-label">Seleccionar grado</label>
                    <select name="grado" id="grado" class="form-control">
                        <option value="">Todos los grados</option>
                        @foreach($grados as $grado)
                            <option value="{{ $grado->id }}" {{ $gradoSelected == $grado->id ? 'selected' : '' }}>
                                {{ $grado->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('estudiantes.primaria') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table id="tableprimaria" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Grado / Sección</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estudiantesPrimaria as $estudiante)
                        <tr>
                            <td>{{ $estudiante->Nombre }}</td>
                            <td>{{ $estudiante->Apellido }}</td>
                            <td>
                                {{ $estudiante->matriculas->last()->grupos->grados->Nombre ?? 'N/A' }}
                                ({{ $estudiante->matriculas->last()->grupos->Descripcion ?? '-' }})
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{route('estudiantes.index')}}" class="btn btn-primary">Volver</a>

</div>

</div>



@stop

@section('js')
    <!-- jQuery ya viene con AdminLTE -->
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

  <script>
    $(document).ready(function() {
        $('#tableprimaria').DataTable({
            dom: '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >' +
                 '<"row" <"col-12" tr> >' +
                 '<"row" <"col-sm-12 d-flex justify-content-start" f> >',
            paging: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            buttons: [
                { extend: 'copy', text: 'Copiar' },
                { extend: 'csv', text: 'CSV' },
                { extend: 'excel', text: 'Excel' },
                { extend: 'pdf', text: 'PDF' },
                { extend: 'print', text: 'Imprimir' }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });
    });
  </script>
@stop
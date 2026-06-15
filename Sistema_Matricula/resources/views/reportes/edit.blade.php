@extends('adminlte::page')

@section('title', 'Reportes')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Editar Reporte</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">Editar Reporte</div>
        <div class="card-body">
            <form class="edit-form"  action="{{ route('reportes.update', $reporte->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

             
                 <div class="form-group mb-2">
                        <label for="id_estudiante">Estudiantes</label>
                        <div class="input-group w-50">
                            <input type="hidden" name="id_estudiante" id="id_estudiante" value="{{$reporte->id_estudiante}}" required>
                            
                               <input type="text" id="nombre_stu_display" 
                            class="form-control form-control-sm" 
                            value="{{ $reporte->estudiantes->Nombre ?? '' }}"  
                            readonly required>
                        <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalstu">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('estudiantes.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                          </div>
                  </div>

            
            
                <div class="form-group mb-3">
                    <label for="titulo">Título de Reporte:</label>
                    <input type="text" name="titulo" class="form-control form-control-sm w-50" value="{{$reporte->titulo}}" required>
                </div>


                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                  <textarea name="descripcion" rows="4" 
                    class="form-control form-control-sm w-50" 
                    placeholder="Escribe una descripción ..." required>{{ $reporte->descripcion }}</textarea>
                   
                </div>
                
                <div class="form-group mb-3">
                        <label for="tipo">Tipo:</label>
                        <!-- Corregido: Se eliminó value y se añadió la lógica de selección -->
                        <select name="tipo" class="form-control form-control-sm w-50" required>
                            <option value="conducta" {{ $reporte->tipo == 'conducta' ? 'selected' : '' }}>Conducta</option>
                            <option value="rendimiento" {{ $reporte->tipo == 'rendimiento' ? 'selected' : '' }}>Rendimiento</option>
                            <option value="asistencia" {{ $reporte->tipo == 'asistencia' ? 'selected' : '' }}>Asistencia</option>
                        </select>
                    </div>

                    
               
             <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('reportes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
             
        </div>
    </div>
</div>
@include('components.modal_rep_estudiantes')
@stop
@section('js')
<script> 
    function seleccionarEstu(id, nombreCompleto) {
                        $('#id_estudiante').val(id);
                        $('#nombre_stu_display').val(nombreCompleto);
                        $('#modalstu').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_stu_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                        });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalstu').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
                    });
</script>
@stop
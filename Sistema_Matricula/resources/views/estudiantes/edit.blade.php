@extends('adminlte::page')

@section('title', 'Editar Estudiante')

@section('plugins.Datatables', true)
@section('content')
<div class="container">
    <div class="card">
          <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
        <div class="card-header">Editar Estudiante</div>
        <div class="card-body">
            <form action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                <div class="form-group">
                    <label for="Código_Persona">Código de Persona</label>
                    <input type="text" name="Código_Persona" class="form-control form-control-sm w-50" value="{{ $estudiante->Código_Persona }}" required>
                </div>

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" value="{{ $estudiante->Nombre }}" required>
                </div>

                <div class="form-group">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control form-control-sm w-50" value="{{ $estudiante->Apellido }}" required>
                </div>

                <div class="form-group">
                    <label for="Sexo">Sexo</label>
                    <select name="Sexo" class="form-control form-control-sm w-50" required>
                        <option value="F" {{ $estudiante->Sexo == 'F' ? 'selected' : '' }}>F</option>
                        <option value="M" {{ $estudiante->Sexo == 'M' ? 'selected' : '' }}>M</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Fecha_N">Fecha de Nacimiento</label>
                    <input type="date" name="Fecha_N" class="form-control form-control-sm w-50" value="{{ $estudiante->Fecha_N }}" required>
                </div>

               

                <div class="form-group">
                    <label for="Celular">Celular</label>
                    <input type="number" name="Celular" class="form-control form-control-sm w-50" value="{{ $estudiante->Celular }}" required>
                </div>

               
              <div class="form-group mb-2">
                    <label for="id_padre">Padre o Tutor</label>
                    <div class="input-group w-50">
                        <input type="hidden" name="id_padre" id="id_padre" value="{{ $estudiante->id_padre }}" required>
                        
                        <input type="text" id="nombre_padre_display" 
                            class="form-control form-control-sm" 
                            value="{{ $estudiante->padre->Nombre_o_Tutor }} {{ $estudiante->padre->Apellido }}" 
                            readonly required>
                        
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalBuscarPadre">
                                <i class="fas fa-search"></i> Cambiar
                            </button>
                        </div>
                    </div>
                </div>
                <!-- //////////comarcas////////////////////// -->
                     <div class="form-group mb-2">
                    <label for="id_comarca">Comarcas</label>
                    <div class="input-group w-50">
                        <input type="hidden" name="id_comarca" id="id_comarca" value="{{ $estudiante->id_comarca }}" required>
                        
                        <input type="text" id="nombre_com_display" 
                            class="form-control form-control-sm" 
                            value="{{ $estudiante->comarca ? $estudiante->comarca->Nombre : 'Sin Comarca' }}" 
                            readonly required>
                        
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalBuscarcomarca">
                                <i class="fas fa-search"></i> Cambiar
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

@include('components.modal_padres')
@include('components.modal_comarca')
@endsection
  @section('js')
                        <script>
                        function seleccionarPadre(id, nombreCompleto) {
                        $('#id_padre').val(id);
                        $('#nombre_padre_display').val(nombreCompleto);
                        $('#modalBuscarPadre').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_padres_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                        });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalBuscarPadre').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
                    });
                    /////////////////comarcas////////////////////////
                    function seleccionarcom(id, nombreCompleto) {
                        $('#id_comarca').val(id);
                        $('#nombre_com_display').val(nombreCompleto);
                        $('#modalBuscarcomarca').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_com_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                        });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalBuscarcomarca').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
                    });
                            
        </script>
    @stop
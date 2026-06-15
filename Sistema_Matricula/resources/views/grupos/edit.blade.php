@extends('adminlte::page')

@section('title', 'Editar Sección')
@section('plugins.Datatables', true)
@section('content')
<div class="container">
    <div class="card">
          <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
        <div class="card-header">Editar Sección</div>
        <div class="card-body">
            <form class="edit-form" action="{{ route('grupos.update', $grupo->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion --}}

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Código">Código</label>
                            <input type="text" name="Código" class="form-control form-control-sm" value="{{ $grupo->Código }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Nombre">Nombre</label>
                            <input type="text" name="Nombre" class="form-control form-control-sm" value="{{ $grupo->Nombre }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Descripcion">Descripcion</label>
                            <input type="text" name="Descripcion" class="form-control form-control-sm" value="{{ $grupo->Descripcion }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="id_turno">Turnos</label>
                            <div class="input-group">
                                <input type="hidden" name="id_turno" id="id_turno" value="{{ $grupo->id_turno }}" required>
                                <input type="text" id="nombre_tur_display" class="form-control form-control-sm" value="{{ $grupo->turnos->Nombre }}" readonly required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalturno">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    <!-- <a href="{{ route('turnos.create') }}" class="btn btn-sm btn-primary ms-1 ml-2">
                                        <i class="fas fa-plus"></i>
                                    </a> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="id_grado">Grados</label>
                            <div class="input-group">
                                <input type="hidden" name="id_grado" id="id_grado" value="{{ $grupo->id_grado }}" required>
                                <input type="text" id="nombre_grado_display" class="form-control form-control-sm" value="{{ $grupo->grados->Nombre }}" readonly required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalgrado">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    <!-- <a href="{{ route('grados.create') }}" class="btn btn-sm btn-primary ms-1 ml-2">
                                        <i class="fas fa-plus"></i>
                                    </a> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="id_periodo_academicos">Periodo Académico</label>
                            <select name="id_periodo_academicos" class="form-control form-control-sm" required>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ $grupo->id_periodo_academicos == $periodo->id ? 'selected' : '' }}>{{ $periodo->id }} {{ $periodo->Nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
        @include('components.modal_sec_turno')
            @include('components.modal_sec_grado')
@endsection
@section('js')
             <script>
                   function seleccionarturnos(id, nombreCompleto) {
                        $('#id_turno').val(id);
                        $('#nombre_tur_display').val(nombreCompleto);
                        $('#modalturno').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_turno_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                    });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalturno').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
             });
             //////////////Script para interactuar con el modals de grados////
              function seleccionargrados(id, nombreCompleto) {
                        $('#id_grado').val(id);
                        $('#nombre_grado_display').val(nombreCompleto);
                        $('#modalgrado').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_grado_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                    });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalgrado').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
             });
</script>
@stop

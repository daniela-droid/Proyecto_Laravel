@extends('adminlte::page')

@section('title', 'Agregar Sección')
@section('plugins.Datatables', true)
@section('content')
<div class="container">
     <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
    <div class="card shadow-sm">
     <!--   <div class="card-header bg-dark text-white">-->
           
            <h4 class="mb-0" style="background-color: #e0e5ee; ><i class="fas fa-user-plus"></i> Agregar Sección</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('grupos.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}


                <div class="form-group mb-2">
                    <label for="Código">Código</label>
                    <input type="text" name="Código" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                       <label for="Descripcion">Descripcion</label>
                    <input type="text" name="Descripcion" class="form-control form-control-sm w-50" required>
                </div>

                
            
             <div class="form-group mb-2">
                        <label for="id_turno">Turnos</label>
                        <div class="input-group w-50">
                            <input type="hidden" name="id_turno" id="id_turno" required>
                            
                            <input type="text" id="nombre_tur_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalturno">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('turnos.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                           </div>
                </div>

              

                 <div class="form-group mb-2">
                        <label for="id_grado">Grados</label>
                        <div class="input-group w-50">
                            <input type="hidden" name="id_grado" id="id_grado" required>
                            
                            <input type="text" id="nombre_grado_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalgrado">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('grados.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                           </div>
                </div>


                 <div class="form-group mb-3">
                <label for="id_periodo_academicos">Periodo Académico</label>
                <select name="id_periodo_academicos" class="form-control form-control-sm w-50" required>
                    <option value="" disabled selected>-- Seleccione el Periodo del Grupo --</option>
                    @foreach($periodos as $periodo)
                       <option value="{{ $periodo->id }}">{{ $periodo->id }} {{ $periodo->Nombre }}</option>
                    @endforeach
                </select>
            </div>


                
                   <button type="submit" class="btn btn-primary">Guardar</button>
                
                <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
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

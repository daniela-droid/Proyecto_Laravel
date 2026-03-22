@extends('adminlte::page')

@section('title', 'Agregar Estudiante')
<!-- //importante para que las tablas de modals de activen -->
@section('plugins.Datatables', true)
@section('content')
<div class="container">
    <div class="card shadow-sm">
     <!--   <div class="card-header bg-dark text-white">-->
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Estudiante</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('estudiantes.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}


                <div class="form-group mb-2">
                    <label for="Código_Persona">Código_Persona</label>
                    <input type="text" name="Código_Persona" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                       <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control form-control-sm w-50" required>
                </div>

                

               <div class="form-group mb-2"> 
                    <label for="">Sexo</label>
                 <select name="Sexo" class="form-control form-control-sm w-50" required> 
                    <option value="F">F</option> <option value="M">M</option> </select>
                 </div>

                <div class="form-group mb-2">
                    <label for="Fecha_N">Fecha de Nacimiento</label>
                    <input type="date" name="Fecha_N" class="form-control form-control-sm w-50" required>
                </div>

               

                <div class="form-group mb-2">
                      <label for="Celular">Celular</label>
                    <input type="text" name="Celular" class="form-control form-control-sm w-50" required>
                </div>

                    <div class="form-group mb-2">
                        <label for="id_padre">Padre o Tutor Seleccionado</label>
                        <div class="input-group w-50">
                            <input type="hidden" name="id_padre" id="id_padre" required>
                            
                            <input type="text" id="nombre_padre_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalBuscarPadre">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                              <a href="{{route('padres.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                        </div>
                </div>

              

                <div class="form-group mb-3">
                <label for="id_comarca">Comarca</label>
                <select name="id_comarca" class="form-control form-control-sm w-50" required>
                    <option value="" disabled selected>-- Seleccione una Comarca --</option>
                    @foreach($comarca as $comarca)
                       <option value="{{ $comarca->id }}">{{ $comarca->Comarca }}</option>
                    @endforeach
                </select>
            </div>
                
                   <button type="submit" class="btn btn-primary">Guardar</button>
                
                <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>


        {{-- 1. EL MODAL SE INCLUYE AQUÍ (Antes del stop del contenido) --}}
            @include('components.modal_padres')

 @endsection

        {{-- 2. EL JAVASCRIPT VA EN SU PROPIA SECCIÓN --}}
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

                            
        </script>
    @stop

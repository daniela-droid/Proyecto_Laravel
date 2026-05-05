@extends('adminlte::page')

@section('title', 'Agregar Docentes')
@section('plugins.Datatables', true)
@section('content')
<div class="container">
    <div class="card shadow-sm">
      <!--  <div class="card-header bg-green text-white">-->
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Docente</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('docentes.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}
 
               <div class="row">
           
                <div class="col-md-4">
                    <div class="form-group mb-2">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control " required>
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group mb-2">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control " required>
                </div>
                </div>
                <div class="col-md-4">

                <div class="form-group mb-2"> 
                    <label for="Email">Email</label>
                     <input type="email" name="Email" class="form-control " >
              
                   </div>
                </div>
               </div>

             <div class="row">
                <div class="col-md-4">
            
                <div class="form-group mb-2">
                       <label for="FechadeNacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="FechadeNacimiento"  class="form-control " required>
                </div>
                </div>
                
                <div class="col-md-4">
                     <div class="form-group mb-2">
                    <label for="Telefono">Telefono</label>
                      <input type="tel" name="Telefono" class="form-control "  title="Por favor, introduce almenos 8 dígitos numéricos" 
                required>
                </div>
                </div>
                <div class="col-md-">
                      <div class="form-group mb-2">
                        <label for="id_especialidads">Especialidades</label>
                        <div class="input-group ">
                            <input type="hidden" name="id_especialidads" id="id_especialidads" required>
                            
                            <input type="text" id="nombre_modalidad_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalespecialidad">
                                    <i class="fas fa-search"></i> Buscar
                                </button>

                            </div>
                         
                            <a href="{{route('especialidades.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
               
                           </div>
                    </div>
                </div>
               <div class="col-md-4">
                 
               <div class="form-group mb-2">
                        <label for="id_usuario">Usuarios</label>
                        <div class="input-group ">
                            <input type="hidden" name="id_usuario" id="id_usuario" required>
                            
                            <input type="text" id="nombre_user_display"  class="form-control form-control-sm w-50" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modaluser">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                              <a href="{{route('usuarios.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                           </div>
                    </div>
                </div>
            
               </div>

             
            <div class="row">
                 <div class="col-md-8">
                    <hr>
                </div>
                 <div class="col-md-8">
                    <button type="submit" class="btn btn-primary">   <i class="fas fa-save"></i> Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
               

               

                </div>
            </form>
        </div>
    </div>
</div>

   {{-- 1. EL MODAL SE INCLUYE AQUÍ (Antes del stop del contenido) --}}
            @include('components.modal_especialidades')
            @include('components.modal_user_docente')
@endsection

        {{-- 2. EL JAVASCRIPT VA EN SU PROPIA SECCIÓN --}}
        @section('js')
                        <script>
                        function seleccionarEspecialidades(id, nombreCompleto) {
                        $('#id_especialidads').val(id);
                        $('#nombre_modalidad_display').val(nombreCompleto);
                        $('#modalespecialidad').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_especialidades_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                        });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalespecialidad').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
                    });
////////////////////////////////////////////////////////////////////////////////////
                   
                        function seleccionaruser(id, nombreCompleto) {
                        $('#id_usuario').val(id);
                        $('#nombre_user_display').val(nombreCompleto);
                        $('#modaluser').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_user_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                        });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modaluser').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
                    });
                            
        </script>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
    // Usamos la URL actual para que cada formulario tenga su propio "baúl" de datos
    const storagePrefix = "form_data_" + window.location.pathname;
    const form = document.querySelector('form');
    
    if (!form) return; // Si no hay formulario en esta página, no hace nada

    const inputs = form.querySelectorAll('input, select, textarea');

    // 1. CARGAR: Al entrar, rellena lo que encuentre para ESTA página
    inputs.forEach(input => {
        if (input.name && input.type !== 'password') { 
            const savedValue = localStorage.getItem(storagePrefix + "_" + input.name);
            if (savedValue !== null) {
                input.value = savedValue;
            }
        }
    });

    // 2. GUARDAR: Escucha cambios en cualquier input
    form.addEventListener('input', function(e) {
        if (e.target.name && e.target.type !== 'password') {
            localStorage.setItem(storagePrefix + "_" + e.target.name, e.target.value);
        }
    });

    // 3. LIMPIAR: Borra solo cuando el usuario guarda (submit)
    form.addEventListener('submit', function() {
        inputs.forEach(input => {
            localStorage.removeItem(storagePrefix + "_" + input.name);
        });
    });
});

        </script>
    @stop
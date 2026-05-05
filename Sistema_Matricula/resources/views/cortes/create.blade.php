@extends('adminlte::page')

@section('title', 'Agregar ')
@section('plugins.Datatables', true)
@section('content')
<div class="container">
    <div class="card shadow-sm">
     <!--   <div class="card-header bg-dark text-white">-->
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Corte Evaluativo</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('cortes.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}

                <div class="row">
                    <div class="col-md-4">
                     <div class="form-group mb-2">
                        <label for="id_modalidades">Modalidades</label>
                        <div class="input-group w-50">
                            <input type="hidden" name="id_modalidades" id="id_modalidades" required>
                            
                            <input type="text" id="nombre_m_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalm">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('modalidades.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                         </div>
                </div>
                    </div>
                    <div class="col-md-4">
                     <div class="form-group mb-2">
                    <label for="nombre">Seleccione el Corte</label>
                    <select name="nombre" id="nombre" class="form-control" required>
                        <option value="" selected disabled>-- Seleccione un corte --</option>
                        <option value="I Corte">I Corte</option>
                        <option value="II Corte">II Corte</option>
                        <option value="III Corte">III Corte</option>
                        <option value="IV Corte">IV Corte</option>
                    </select>
                </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group mb-2">
                       <label for="ponderacion">Ponderación</label>
                    <input type="number" name="ponderacion" class="form-control " placeholder="0" required>
                </div>
                    </div>
                </div>


                 <div class="row">
                   
                    <div class="col-md-4">

                <div class="form-group mb-2">
                <label for="id_periodo_academicos">Periodos Academicos</label>
                <select name="id_periodo_academicos" class="form-control " required>
                  <option value="" disabled selected>-- Seleccione--</option>
                    @foreach($periodos as $periodo)
                         <option value="{{ $periodo->id }}">{{ $periodo->id}} {{ $periodo->Nombre }}</option>
                    @endforeach
                </select>
              
                </div>
                    </div>

                    <div class="col-md-4">
                        
                 <div class="form-group mb-2">
                       <label for="fecha_inicio">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control " required>
                </div>
            
                    </div>
                    <div class="col-md-4">
                        
              <div class="form-group mb-2">
                       <label for="fecha_fin">Fecha Fin</label>
                    <input type="date" name="fecha_fin" class="form-control " required>
                </div>
                    </div>
                </div>

              <div class="row">
                <div class="col-md-8">
<hr>
                </div>
                <div class="col-md-8">

                   <button type="submit" class="btn btn-primary">  <i class="fas fa-save"></i> Guardar</button>
                
                <a href="{{ route('cortes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
              </div>

                
                </div>
            </form>
        </div>
    </div>
</div>
    @include('components.modal_cortes_mod')
@endsection
@section('js')
<script>
     function seleccionarm(id, nombreCompleto) {
                        $('#id_modalidades').val(id);
                        $('#nombre_m_display').val(nombreCompleto);
                        $('#modalm').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_m_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                        });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalm').on('shown.bs.modal', function () {
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
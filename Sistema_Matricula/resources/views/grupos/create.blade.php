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
            <form action="{{ route('grupos.store') }}" method="POST" id="formGrupoCreate">
                @csrf {{-- Seguridad de Laravel --}}
                <input type="hidden" name="from" value="{{ request('from') }}">
                <input type="hidden" name="redirect_choice" id="redirect_choice" value="grupos">

                <div class="row">
                
                     <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label for="Nombre">Nombre</label>
                        <select name="Nombre" class="form-control" id="nombreSeccion" required>
                            <option value="">-- Selecciona --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label for="Código">Código</label>
                        <input type="text" name="Código" class="form-control" id="codigoSeccion" readonly required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label for="Descripcion">Descripcion</label>
                        <input type="text" name="Descripcion" class="form-control" id="descripcionSeccion" readonly required>
                    </div>
                </div>
                </div>

                 <div class="row">
                    <div class="col-md-4">

                
            
             <div class="form-group mb-2">
                        <label for="id_turno">Turnos</label>
                        <div class="input-group ">
                            <input type="hidden" name="id_turno" id="id_turno" required>
                            
                            <input type="text" id="nombre_tur_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalturno">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                             
                            </div>
                         
                           </div>
                         </div>

              
                    </div>
                    <div class="col-md-4">
                       <div class="form-group mb-2">
                        <label for="id_grado">Grados</label>
                        <div class="input-group ">
                            <input type="hidden" name="id_grado" id="id_grado" required>
                            
                            <input type="text" id="nombre_grado_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalgrado">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                             
                            </div>
                         
                           </div>
                </div>
                    </div>
                    <div class="col-md-4">
                        
                 <div class="form-group mb-3">
                <label for="id_periodo_academicos">Periodo Académico</label>
                <select name="id_periodo_academicos" class="form-control " required>
                    <option value="" disabled selected>-- Seleccione el Periodo de la seccion --</option>
                    @foreach($periodos as $periodo)
                       <option value="{{ $periodo->id }}">{{ $periodo->id }} {{ $periodo->Nombre }}</option>
                    @endforeach
                </select>
            </div>
                    </div>
                </div>
             
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-4">
                <button type="submit" class="btn btn-primary">   <i class="fas fa-save"></i> Guardar</button>
                
                <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
    
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

                    function agregarTurnoNuevo() {
                        fetch('/turnos/store-rapido', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: new FormData(document.getElementById('formTurnoRapido'))
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                if (window.tablaTurnos) {
                                    window.tablaTurnos.row.add([
                                        `<strong>${data.nombre}</strong>`,
                                        `<button class="btn btn-sm btn-success" onclick="seleccionarturnos(${data.id}, '${data.nombre}')">
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>`
                                    ]).draw(false);
                                } else {
                                    $('#tabla_turno_modal tbody').prepend(`
                                        <tr>
                                            <td><strong>${data.nombre}</strong></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" onclick="seleccionarturnos(${data.id}, '${data.nombre}')">
                                                    <i class="fas fa-check"></i> Seleccionar
                                                </button>
                                            </td>
                                        </tr>
                                    `);
                                }
                                seleccionarturnos(data.id, data.nombre);
                                document.getElementById('formTurnoRapido').reset();
                                alert('Turno creado y agregado a la lista');
                            }
                        });
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        window.tablaTurnos = $('#tabla_turno_modal').DataTable({
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

                    function agregarGradoNuevo() {
                        fetch('/grados/store-rapido', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: new FormData(document.getElementById('formGradoRapido'))
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                if (window.tablaGrados) {
                                    window.tablaGrados.row.add([
                                        `<strong>${data.nombre}</strong>`,
                                        `<button class="btn btn-sm btn-success" onclick="seleccionargrados(${data.id}, '${data.nombre}')">
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>`
                                    ]).draw(false);
                                } else {
                                    $('#tabla_grado_modal tbody').prepend(`
                                        <tr>
                                            <td><strong>${data.nombre}</strong></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" onclick="seleccionargrados(${data.id}, '${data.nombre}')">
                                                    <i class="fas fa-check"></i> Seleccionar
                                                </button>
                                            </td>
                                        </tr>
                                    `);
                                }
                                seleccionargrados(data.id, data.nombre);
                                document.getElementById('formGradoRapido').reset();
                                alert('Grado creado y agregado a la lista');
                            }
                        });
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        window.tablaGrados = $('#tabla_grado_modal').DataTable({
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

<script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('formGrupoCreate');
                const redirectInput = document.getElementById('redirect_choice');
                const returnFromHorarios = '{{ request('from') === 'horarios' ? '1' : '0' }}';

                if (form && redirectInput && returnFromHorarios === '1') {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        const regresar = confirm(
                            'Sección creada correctamente.\n\n' +
                            'Aceptar = Volver a Crear Horario.\n' +
                            'Cancelar = Ir al índice de Secciones.'
                        );
                        redirectInput.value = regresar ? 'horarios' : 'grupos';
                        form.submit();
                    });
                }
            });
        </script>

        <script>
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

        <script>
            document.getElementById('nombreSeccion').addEventListener('change', function() {
    const nombre = this.value;
    const codigoInput = document.getElementById('codigoSeccion');
    const descripcionInput = document.getElementById('descripcionSeccion');
    
    if (nombre) {
        // Código random: Letra + 6 dígitos
        const numeroRandom = Math.floor(100000 + Math.random() * 900000);
        codigoInput.value = nombre + numeroRandom;
        
        // Descripción automática
        descripcionInput.value = 'Sección ' + nombre;
    } else {
        codigoInput.value = '';
        descripcionInput.value = '';
    }
});
        </script>
@stop

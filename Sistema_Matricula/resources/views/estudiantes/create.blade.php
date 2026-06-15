@extends('adminlte::page')

@section('title', 'Agregar Estudiante')
<!-- //importante para que las tablas de modals de activen -->
@section('plugins.Datatables', true)
@section('css')
<style>
a:hover{
    background-color:#5A94C1 !important;
    color:white;
}
button:hover{
    background-color:#5A94C1 !important;
    color:white;
}
</style>

@stop
@section('content')
<div class="container">
   
   
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Estudiante</h4>
        </div>
        <div class="card-body">
            <form id="formEstudianteCreate" action="{{ route('estudiantes.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}
                <input type="hidden" name="from" value="{{ request('from') }}">
                <input type="hidden" name="redirect_choice" id="redirect_choice" value="matriculas">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label for="codigo_persona">Código Unico de Persona</label>
                                <input id="codigo_persona" type="text" name="Código_Persona" class="form-control @error('Código_Persona') is-invalid @enderror" value="{{ old('Código_Persona') }}" placeholder="Ingresa el código nacional de 7 u 8 dígitos">
                                @error('Código_Persona')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                            <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label for="c_temporal">Código Temporal</label>
                                <input id="c_temporal" type="text" name="c_temporal" class="form-control @error('c_temporal') is-invalid @enderror" value="{{ old('c_temporal') }}" placeholder="Ej. A1B2C3D4E5F67890" maxlength="16" pattern="[0-9A-Fa-f]{16}" autocomplete="off" autocapitalize="characters">
                                <small class="form-text text-muted">Ingrese este código solo si no tiene Código Único. Debe tener exactamente 16 caracteres hexadecimales (0-9 y A-F).</small>
                                @error('c_temporal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label for="Nombre">Nombres</label>
                                <input id="Nombre" type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror" required value="{{ old('Nombre') }}" placeholder="Nombres del estudiante">
                                @error('Nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                    </div>




                  <div class="row">
                     <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label for="Apellido">Apellidos</label>
                                <input id="Apellido" type="text" name="Apellido" class="form-control @error('Apellido') is-invalid @enderror" required value="{{ old('Apellido') }}" placeholder="Apellidos del estudiante">
                                @error('Apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                <div class="col-md-4">
               <div class="form-group mb-2"> 
                    <label for="Sexo">Sexo</label>
                 <select name="Sexo" class="form-control @error('Sexo') is-invalid @enderror" required> 
                    <option value="">Seleccione...</option>
                    <option value="F" {{ old('Sexo') == 'F' ? 'selected' : '' }}>F</option> 
                    <option value="M" {{ old('Sexo') == 'M' ? 'selected' : '' }}>M</option> 
                 </select>
                 @error('Sexo')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                 </div>
                  </div>


                  <div class="col-md-4">
                <div class="form-group mb-2">
                    <label for="Fecha_N">Fecha de Nacimiento</label>
                    <input id="Fecha_N" type="date" name="Fecha_N" class="form-control @error('Fecha_N') is-invalid @enderror" required value="{{ old('Fecha_N') }}">
                    @error('Fecha_N')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                    </div>


                </div>

                <div class="row">

                  <div class="col-md-4">
                <div class="form-group mb-2">
                      <label for="Celular">Celular</label>
                    <input id="Celular" type="text" name="Celular" class="form-control @error('Celular') is-invalid @enderror" required value="{{ old('Celular') }}" placeholder="+50512345678" pattern="\+505[0-9]{8}" maxlength="12">
                    @error('Celular')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="id_padre">Padre o Tutor Seleccionado</label>
                            <div class="input-group @error('id_padre') is-invalid @enderror">
                                <input type="hidden" name="id_padre" id="id_padre" required value="{{ old('id_padre') }}">
                                <input type="text" id="nombre_padre_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required value="{{ old('nombre_padre_display') }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalBuscarPadre">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                            @error('id_padre')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="id_comarca">Comarcas</label>
                            <div class="input-group @error('id_comarca') is-invalid @enderror">
                                <input type="hidden" name="id_comarca" id="id_comarca" required value="{{ old('id_comarca') }}">
                                <input type="text" id="nombre_com_display" class="form-control form-control-sm" placeholder="Haga clic en la lupa para buscar..." readonly required value="{{ old('nombre_com_display') }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalBuscarcomarca">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                            @error('id_comarca')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                </div>
               <hr>
                   <button type="submit" class="btn btn-primary">   <i class="fas fa-save"></i> Guardar</button>
                 <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
                 
                </div>
            </form>
        </div>
  
</div>


        {{-- 1. EL MODAL SE INCLUYE AQUÍ (Antes del stop del contenido) --}}
            @include('components.modal_padres')
            @include('components.modal_comarca')

@stop

        {{-- 2. EL JAVASCRIPT VA EN SU PROPIA SECCIÓN --}}
        @section('js')
<script>
$(document).ready(function() {
    inicializarTablaModal('#tabla_padres_modal', 'No se encontraron padres');
    inicializarTablaModal('#tabla_com_modal', 'No se encontraron comarcas');

    $('#modalBuscarPadre, #modalBuscarcomarca').on('shown.bs.modal', function () {
        $.fn.DataTable.tables({ visible: true, api: true }).columns.adjust();
        $(this).find('input[type="search"]:visible').first().trigger('focus');
    });

    // Delegación de eventos para seleccionar padre (compatible con DataTable)
    $(document).on('click', '.btn-seleccionar-padre', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        seleccionarPadre(id, nombre);
    });
});

function inicializarTablaModal(selector, mensajeVacio) {
    if (!$.fn.DataTable || !$(selector).length) {
        return null;
    }

    if ($.fn.DataTable.isDataTable(selector)) {
        return $(selector).DataTable();
    }

    return $(selector).DataTable({
        dom:
            "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        paging: true,
        pagingType: "simple_numbers",
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 5,
        lengthMenu: [[5, 10, 25], [5, 10, 25]],
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_",
            info: "Mostrando _START_ a _END_ de _TOTAL_",
            infoEmpty: "Sin registros",
            zeroRecords: mensajeVacio,
            emptyTable: mensajeVacio,
            paginate: {
                previous: "Anterior",
                next: "Siguiente"
            }
        }
    });
}

function seleccionarPadre(id, nombre) {
    // Llena los campos del formulario principal
    document.getElementById('id_padre').value = id;
    document.getElementById('nombre_padre_display').value = nombre;

    // Cierra modal
    $('#modalBuscarPadre').modal('hide');

    // Notificación simple
    alert('✅ Padre seleccionado: ' + nombre);
}

function agregarPadreNuevo() {
    normalizarCamposPadreRapido();

    fetch('/padres/store-rapido', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: new FormData(document.getElementById('formPadreRapido'))
    })
    .then(r => r.json())
    .then(data => {
        if (data.id) {
            // Actualiza DataTable
            const table = $('#tabla_padres_modal').DataTable();
            table.row.add([
                `<strong>${data.nombre}</strong>`,
                `<span class="badge badge-info">Tutor</span>`,
                `<button type="button" class="btn btn-sm btn-success btn-seleccionar-padre" data-id="${data.id}" data-nombre="${data.nombre}"><i class="fas fa-check"></i> Seleccionar</button>`
            ]).draw();

            // Selecciona automáticamente
            seleccionarPadre(data.id, data.nombre);

            // Limpia form
            document.getElementById('formPadreRapido').reset();

            alert('Padre creado y agregado a la lista');
        }
    });
}

function normalizarCamposPadreRapido() {
    const cedula = document.querySelector('#formPadreRapido [name="Cedula"]');
    const telefono = document.querySelector('#formPadreRapido [name="Telefono"]');

    if (cedula) {
        cedula.value = cedula.value.toUpperCase().replace(/[^0-9A-Z]/g, '').slice(0, 14);
    }

    if (telefono && telefono.value.trim() !== '' && !telefono.value.startsWith('+505')) {
        telefono.value = '+505' + telefono.value.replace(/\D/g, '').replace(/^505?/, '');
        telefono.value = telefono.value.slice(0, 12);
    }
}

// COMARCAS
function seleccionarcom(id, nombreCompleto) {
    $('#id_comarca').val(id);
    $('#nombre_com_display').val(nombreCompleto);
    $('#modalBuscarcomarca').modal('hide');
}

function agregarComarcaNueva() {
    fetch('/comarcas/store-rapido', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: new FormData(document.getElementById('formComarcaRapido'))
    })
    .then(r => r.json())
    .then(data => {
        if (data.id) {
            const row = [
                `<strong>${data.nombre}</strong>`,
                `<button type="button" class="btn btn-sm btn-success" onclick="seleccionarcom(${data.id}, '${data.nombre}')"><i class="fas fa-check"></i> Seleccionar</button>`
            ];

            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tabla_com_modal')) {
                $('#tabla_com_modal').DataTable().row.add(row).draw();
            } else {
                $('#tabla_com_modal tbody').prepend(`
                    <tr>
                        <td>${row[0]}</td>
                        <td>${row[1]}</td>
                    </tr>
                `);
            }

            seleccionarcom(data.id, data.nombre);
            document.getElementById('formComarcaRapido').reset();
            alert('Comarca creada y agregada a la lista');
        }
    });
}

// Intercepta el GUARDAR
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formEstudianteCreate');
    if (!form) return;

    const fromParam = new URLSearchParams(window.location.search).get('from');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const padreSeleccionado = document.querySelector('input[name="id_padre"]').value;
        const comarcaSeleccionada = document.querySelector('input[name="id_comarca"]').value;
        const celular = document.getElementById('Celular').value.trim();
        const codigoPersona = document.getElementById('codigo_persona').value.trim();
        const codigoTemporalInput = document.getElementById('c_temporal');
        const codigoTemporal = codigoTemporalInput.value.trim().toUpperCase();
        const regexCelular = /^\+505[0-9]{8}$/;
        const regexCodigoPersona = /^[0-9]{7,8}$/;
        const regexCodigoTemporal = /^[0-9A-F]{16}$/;

        codigoTemporalInput.value = codigoTemporal;

        if (!padreSeleccionado || !comarcaSeleccionada) {
            alert('⚠️ Completa Padre y Comarca primero');
            return;
        }

        if (codigoPersona && !regexCodigoPersona.test(codigoPersona)) {
            alert('⚠️ El Código Único debe tener 7 u 8 dígitos numéricos');
            document.getElementById('codigo_persona').focus();
            return;
        }

        if (codigoTemporal && !regexCodigoTemporal.test(codigoTemporal)) {
            alert('⚠️ El Código Temporal debe tener exactamente 16 caracteres hexadecimales (0-9 y A-F)');
            codigoTemporalInput.focus();
            return;
        }

        if (!regexCelular.test(celular)) {
            alert('⚠️ El teléfono debe tener el formato +50512345678 (8 dígitos después de +505)');
            document.getElementById('Celular').focus();
            return;
        }

        if (fromParam === 'matriculas') {
            const respuesta = confirm(
                '✅ Estudiante listo para guardar.\n\n' +
                '¿Deseas volver a la creación de matrícula después de guardar este estudiante?\n' +
                '• ACEPTAR → Volver a Crear Matrícula\n' +
                '• CANCELAR → Ir al Listado de Estudiantes'
            );

            document.getElementById('redirect_choice').value = respuesta ? 'matriculas' : 'estudiantes';
            form.submit();
        } else {
            form.submit();
        }
    });

    // LocalStorage para inputs
    const storagePrefix = "form_data_" + window.location.pathname;
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (input.name && input.type !== 'password') {
            const savedValue = localStorage.getItem(storagePrefix + "_" + input.name);
            if (savedValue !== null) {
                input.value = savedValue;
            }
        }
    });
    form.addEventListener('input', function(e) {
        if (e.target.name && e.target.type !== 'password') {
            localStorage.setItem(storagePrefix + "_" + e.target.name, e.target.value);
        }
    });
    form.addEventListener('submit', function() {
        inputs.forEach(input => {
            localStorage.removeItem(storagePrefix + "_" + input.name);
        });
    });

    function capitalizeWords(value) {
        return value.trim().toLowerCase().replace(/\b\w/g, function(letter) {
            return letter.toUpperCase();
        });
    }

    const temporalInput = document.getElementById('c_temporal');
    if (temporalInput) {
        temporalInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^0-9A-F]/g, '').slice(0, 16);
        });
    }
});
</script>
@stop

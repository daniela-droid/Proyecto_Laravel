@extends('adminlte::page')

@section('title', 'Editar Estudiante')

@section('plugins.Datatables', true)
@section('content')
<div class="container">
    <div class="card">
          <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
        <div class="card-header">Editar Estudiante</div>
        <div class="card-body">
            @if(empty($estudiante->Código_Persona) && empty($estudiante->c_temporal))
                <div class="alert alert-warning">
                    Este estudiante no tiene Código Único ni Código Temporal. Puede completar el Código Temporal asignado por el gobierno en este formulario.
                </div>
            @endif
            <form class="edit-form"  action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="codigo_persona">Código Unico de Persona</label>
                            <input id="codigo_persona" type="text" name="Código_Persona" class="form-control form-control-sm @error('Código_Persona') is-invalid @enderror" value="{{ old('Código_Persona', $estudiante->Código_Persona) }}" placeholder="Ingresa el código nacional de 7 u 8 dígitos">
                            <small class="form-text text-muted">Si no tiene código único, ingrese el Código Temporal asignado por el gobierno.</small>
                            @error('Código_Persona')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                        <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="c_temporal">Código Temporal</label>
                            <input id="c_temporal" type="text" name="c_temporal" class="form-control form-control-sm @error('c_temporal') is-invalid @enderror" value="{{ old('c_temporal', $estudiante->c_temporal) }}" placeholder="Ej. A1B2C3D4E5F67890" maxlength="16" pattern="[0-9A-Fa-f]{16}" autocomplete="off" autocapitalize="characters">
                            <small class="form-text text-muted">Sugerencia: complete este campo si el estudiante no tiene Código Único. Debe tener exactamente 16 caracteres hexadecimales (0-9 y A-F).</small>
                            @error('c_temporal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
</div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Nombre">Nombre</label>
                            <input id="Nombre" type="text" name="Nombre" class="form-control form-control-sm" value="{{ $estudiante->Nombre }}" required>
                        </div>
                    </div>


                </div>

                <div class="row">

                 <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Apellido">Apellido</label>
                            <input id="Apellido" type="text" name="Apellido" class="form-control form-control-sm" value="{{ $estudiante->Apellido }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Sexo">Sexo</label>
                            <select name="Sexo" class="form-control form-control-sm" required>
                                <option value="F" {{ $estudiante->Sexo == 'F' ? 'selected' : '' }}>F</option>
                                <option value="M" {{ $estudiante->Sexo == 'M' ? 'selected' : '' }}>M</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Fecha_N">Fecha de Nacimiento</label>
                            <input id="Fecha_N" type="date" name="Fecha_N" class="form-control form-control-sm" value="{{ $estudiante->Fecha_N }}" required>
                        </div>
                    </div>


                </div>

                <div class="row">

                <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Celular">Celular</label>
                            <input id="Celular" type="text" name="Celular" class="form-control form-control-sm @error('Celular') is-invalid @enderror" value="{{ $estudiante->Celular }}" required placeholder="+50512345678" pattern="\+505[0-9]{8}" maxlength="12">
                            @error('Celular')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="id_padre">Padre o Tutor</label>
                            <div class="input-group">
                                <input type="hidden" name="id_padre" id="id_padre" value="{{ $estudiante->id_padre }}" required>
                                <input type="text" id="nombre_padre_display" class="form-control form-control-sm" value="{{ $estudiante->padre ? $estudiante->padre->Nombre_o_Tutor . ' ' . $estudiante->padre->Apellido : 'Sin padre o tutor' }}" readonly required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalBuscarPadre">
                                        <i class="fas fa-search"></i> Cambiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="id_comarca">Comarcas</label>
                            <div class="input-group">
                                <input type="hidden" name="id_comarca" id="id_comarca" value="{{ $estudiante->id_comarca }}" required>
                                <input type="text" id="nombre_com_display" class="form-control form-control-sm" value="{{ $estudiante->comarca ? $estudiante->comarca->Nombre : 'Sin Comarca' }}" readonly required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalBuscarcomarca">
                                        <i class="fas fa-search"></i> Cambiar
                                    </button>
                                </div>
                            </div>
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

                    $(document).ready(function() {
                        inicializarTablaModal('#tabla_padres_modal', 'No se encontraron padres');

                        $(document).on('click', '.btn-seleccionar-padre', function() {
                            seleccionarPadre($(this).data('id'), $(this).data('nombre'));
                        });

                        $('#modalBuscarPadre').on('shown.bs.modal', function () {
                            $.fn.DataTable.tables({ visible: true, api: true }).columns.adjust();
                            $(this).find('input[type="search"]:visible').first().trigger('focus');
                        });
                    });
                    /////////////////comarcas////////////////////////
                    function seleccionarcom(id, nombreCompleto) {
                        $('#id_comarca').val(id);
                        $('#nombre_com_display').val(nombreCompleto);
                        $('#modalBuscarcomarca').modal('hide');
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
                                const table = $('#tabla_padres_modal').DataTable();
                                table.row.add([
                                    `<strong>${data.nombre}</strong>`,
                                    `<span class="badge badge-info">Tutor</span>`,
                                    `<button type="button" class="btn btn-sm btn-success btn-seleccionar-padre" data-id="${data.id}" data-nombre="${data.nombre}"><i class="fas fa-check"></i> Seleccionar</button>`
                                ]).draw();

                                seleccionarPadre(data.id, data.nombre);
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

                    $(document).ready(function() {
                        inicializarTablaModal('#tabla_com_modal', 'No se encontraron comarcas');

                        $('#modalBuscarcomarca').on('shown.bs.modal', function () {
                            $.fn.DataTable.tables({ visible: true, api: true }).columns.adjust();
                            $(this).find('input[type="search"]:visible').first().trigger('focus');
                        });
                    });

                    document.addEventListener('DOMContentLoaded', function() {
                        const temporalInput = document.getElementById('c_temporal');
                        if (!temporalInput) return;
                        temporalInput.addEventListener('input', function() {
                            this.value = this.value.toUpperCase().replace(/[^0-9A-F]/g, '').slice(0, 16);
                        });
                    });
        </script>
    @stop

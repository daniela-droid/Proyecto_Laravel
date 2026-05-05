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

                    <div class="row display-flex">

                        <div class="col-md-4">
                <div class="form-group mb-2">
                    <label for="Código_Persona">Código de Persona</label>
                    <input type="number" name="Código_Persona" class="form-control @error('Código_Persona') is-invalid @enderror" required value="{{ old('Código_Persona') }}">
                    @error('Código_Persona')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                </div>

                  <div class="col-md-4">
                <div class="form-group mb-2">
                    <label for="Nombre">Nombres</label>
                    <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror" required value="{{ old('Nombre') }}">
                    @error('Nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                </div>


                 <div class="col-md-4">
                <div class="form-group mb-2">
                       <label for="Apellido">Apellidos</label>
                    <input type="text" name="Apellido" class="form-control @error('Apellido') is-invalid @enderror" required value="{{ old('Apellido') }}">
                    @error('Apellido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                 </div>

                 </div>




                  <div class="row">
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
                    <input type="date" name="Fecha_N" class="form-control @error('Fecha_N') is-invalid @enderror" required value="{{ old('Fecha_N') }}">
                    @error('Fecha_N')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                    </div>
               
                <div class="col-md-4">
                <div class="form-group mb-2">
                      <label for="Celular">Celular</label>
                    <input type="number" name="Celular" class="form-control @error('Celular') is-invalid @enderror" required value="{{ old('Celular') }}">
                    @error('Celular')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                </div>
                </div>

                <div class="row">
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
    // Inicializar DataTable para el modal de padres
    $('#tabla_padres_modal').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "lengthChange": false,
        "pageLength": 5,
        "language": {
            "search": "Buscar:",
            "zeroRecords": "No se encontraron padres",
            "infoEmpty": "No hay padres disponibles"
        }
    });

    // Delegación de eventos para seleccionar padre (compatible con DataTable)
    $(document).on('click', '.btn-seleccionar-padre', function() {
        console.log('Botón seleccionar padre clickeado');
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        console.log('ID:', id, 'Nombre:', nombre);
        seleccionarPadre(id, nombre);
    });
});

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
                `<button class="btn btn-sm btn-success btn-seleccionar-padre" data-id="${data.id}" data-nombre="${data.nombre}"><i class="fas fa-check"></i> Seleccionar</button>`
            ]).draw();

            // Selecciona automáticamente
            seleccionarPadre(data.id, data.nombre);

            // Limpia form
            document.getElementById('formPadreRapido').reset();

            alert('Padre creado y agregado a la lista');
        }
    });
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
            $('#tabla_com_modal tbody').prepend(`
                <tr>
                    <td><strong>${data.nombre}</strong></td>
                    <td>
                        <button class="btn btn-sm btn-success" onclick="seleccionarcom(${data.id}, '${data.nombre}')">
                            <i class="fas fa-check"></i> Seleccionar
                        </button>
                    </td>
                </tr>
            `);
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
        if (!padreSeleccionado || !comarcaSeleccionada) {
            alert('⚠️ Completa Padre y Comarca primero');
            return;
        }

        if (fromParam === 'matriculas') {
            const respuesta = confirm(
                '✅ Estudiante listo para guardar.\n\n' +
                '¿Quieres ir luego a Matrículas?\n' +
                '• ACEPTAR → Abrir Matriculas\n' +
                '• CANCELAR → Ir al índice de Estudiantes'
            );

            let targetTab = null;
            if (respuesta) {
                targetTab = window.open('', '_blank');
            }

            form.submit();

            if (respuesta && targetTab) {
                targetTab.location.href = '{{ route("matriculas.create") }}';
            }
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
});
</script>
@stop

@extends('adminlte::page')

@section('title', 'Asignaturas')
@section('css')
<style>
/* Estilo extra bonito para el select */
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    transform: scale(1.02);
}


#asignaturaSelect:hover {
    background: linear-gradient(145deg, #e9ecef, #dee2e6);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,123,255,0.15);
}
</style>
@stop
@section('content_header')
    <h1>Asignaturas</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header"  style="background-color:#233858; color:white">Agregar Asignatura</div>
        <div class="card-body">
         
            <form action="{{ route('asignaturas.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}

                <div class="row">
                <div class="col-md-6">
               <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <select name="Nombre" class="form-control" id="asignaturaSelect" required>
                        <option value="">-- Seleccione Asignaturas--</option>
                        <option value="Lengua y Literatura"> Lengua y Literatura</option>
                        <option value="Matemática"> Matemática</option>
                        <option value="Ciencias Naturales"> Ciencias Naturales</option>
                        <option value="Estudios Sociales">Estudios Sociales</option>
                        <option value="Educación Física"> Educación Física</option>
                        <option value="Arte y Cultura"> Arte y Cultura</option>
                        <option value="Inglés"> Inglés</option>
                        <option value="Formación Personal y Ciudadana">Danza</option>
                        <option value="Computación"> Derecho de la mujer</option>
                        <option value="Música">Creciendo en Valores</option>
                    </select>
                </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group">
                    <label for="Descripcion">Descripcion</label>
                    <input type="text" name="Descripcion" class="form-control " required>
                </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                 <div class="form-group">
                    <label for="Código">Código</label>
                    <input type="text" name="Código" class="form-control "  id="codigoAsignatura" readonly required>
                </div>
                </div>
                </div>
                <button type="submit" class="btn btn-primary">   <i class="fas fa-save"></i> Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
@section('js')
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
        <script>
document.getElementById('asignaturaSelect').addEventListener('change', function() {
    const asignatura = this.value;
    const codigoInput = document.getElementById('codigoAsignatura');
    
    if (asignatura) {
        // Generar código: 2 letras de asignatura + 4 dígitos random
        const codigo = generarCodigoAsignatura(asignatura);
        codigoInput.value = codigo;
    } else {
        codigoInput.value = '';
    }
});

function generarCodigoAsignatura(asignatura) {
    // Extraer primeras 2 letras (o abreviatura lógica)
    let abreviatura = '';
    switch(asignatura) {
        case 'Lengua y Literatura': abreviatura = 'LL'; break;
        case 'Matemática': abreviatura = 'MA'; break;
        case 'Ciencias Naturales': abreviatura = 'CN'; break;
        case 'Estudios Sociales': abreviatura = 'ES'; break;
        case 'Educación Física': abreviatura = 'EF'; break;
        case 'Arte y Cultura': abreviatura = 'AC'; break;
        case 'Inglés': abreviatura = 'IN'; break;
        case 'Educación Religiosa': abreviatura = 'ER'; break;
        case 'Formación Personal y Ciudadana': abreviatura = 'FP'; break;
        case 'Computación': abreviatura = 'CO'; break;
        case 'Música': abreviatura = 'MU'; break;
        default: abreviatura = 'XX';
    }
    
    // 4 dígitos random
    const numeroRandom = Math.floor(1000 + Math.random() * 9000);
    return abreviatura + numeroRandom;
}
</script>
@stop
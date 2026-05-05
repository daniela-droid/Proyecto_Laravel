@extends('adminlte::page')

@section('title', 'Agregar Usuarios')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-info">
        <div class="card-header">Agregar Usuarios</div>
        <div class="card-body">

            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf {{-- token de seguridad --}}

              <div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="Email" class="small font-weight-bold">Email</label>
            <input type="email" name="Email" class="form-control form-control-sm" placeholder="ejemplo@correo.com" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="password" class="small font-weight-bold">Password</label>
            <div class="input-group input-group-sm">
                <input type="password" name="password" id="password" class="form-control" style="border-right: none;" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-sm" style="border: 1px solid #ced4da; border-left: none; background: white; color: #6c757d;" onclick="togglePassword('password', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="password_confirmation" class="small font-weight-bold">Confirmar Password</label>
            <div class="input-group input-group-sm">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" style="border-right: none;" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-sm" style="border: 1px solid #ced4da; border-left: none; background: white; color: #6c757d;" onclick="togglePassword('password_confirmation', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fila 2: Roles -->
<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-4">
            <label for="rol" class="small font-weight-bold">Rol</label>
            <select name="rol" class="form-control form-control-sm" required>
                <option value="admin">Admin</option>
                <option value="docentes">Docentes</option>
            </select>
        </div>
    </div>
</div>

<!-- Fila 3: Acciones -->
<div class="row align-items-center">
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary shadow-sm">
            <i class="fas fa-save"></i> Guardar
        </button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary shadow-sm">
            Cancelar
        </a>
    </div>
    
    <div class="col-md-12 my-3">
        <hr>
    </div>

    <div class="col-md-12">
        <a href="{{ route('docentes.create') }}" class="btn btn-outline-warning">
            <i class="fas fa-arrow-left"></i> Ir a Docentes
        </a>
    </div>
</div>

            
            </form>

        </div>
    </div>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
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
@endsection

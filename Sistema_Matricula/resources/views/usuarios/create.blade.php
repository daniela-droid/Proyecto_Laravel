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

               

                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="Email" name="Email" class="form-control form-control-sm w-25" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class=" form-control-sm w-25" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">👁️</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Password</label>
                    <div class="input-group-sm w-50">
                        <input type="password" name="password_confirmation" id="password_confirmation" class=" form-control-sm w-50" required>
                        <button type="button" class="btn btn-outline-secondary " onclick="togglePassword('password_confirmation')">👁️</button>
                        
                    </div>
                </div> 
               

                <div class="form-group">
                    <label for="rol">Rol</label>
                   <select name="rol" class="form-control form-control-sm w-25" required>
            <option value="admin">admin</option>
            <option value="docentes">docentes</option>
        </select>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                  <a href="{{ route('docentes.create') }}" class="btn btn-warning">
                <i class="fas fa-arrow-left"></i> ir a Docentes
            </a>
            </form>

        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === "password" ? "text" : "password";
}
</script>
@endsection

@extends('adminlte::page')

@section('title', 'Agregar Usuarios')

@section('content')
<div class="container">
    <div class="card">
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
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="gmail">Gmail</label>
                    <input type="email" name="gmail" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">👁️</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="rol">Rol</label>
                   <select name="rol" class="form-control" required>
    <option value="admin">admin</option>
    <option value="user">user</option>
</select>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
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

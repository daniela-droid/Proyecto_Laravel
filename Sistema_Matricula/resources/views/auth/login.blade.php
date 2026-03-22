@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Iniciar Sesión')

@section('auth_body')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <!-- Gmail -->
        <div class="input-group mb-3">
            <input type="email" name="Email" class="form-control" placeholder="Correo electrónico" value="{{ old('Email') }}" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <!-- Password -->
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <!-- Botón ingresar -->
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>
        </div>
    </form>
@stop

@section('auth_footer')
    <p class="mb-0 text-center">
        &copy; 2026 Sistema de Matrícula
    </p>
@stop
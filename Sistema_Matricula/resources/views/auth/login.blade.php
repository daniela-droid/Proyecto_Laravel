@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

{{-- Título de la pestaña --}}
@section('title', 'Iniciar Sesión')

{{-- Estilos CSS personalizados --}}
@push('css')
<style>
    /* Contenedor principal más limpio */
    .login-card {
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: none;
    }
       .card-primary.card-outline {
        border-top: 0;
    }

    /* Input-group con floating labels estilo minimalista */
    .floating-input {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .floating-input .form-control {
        border: 2px solid #dee2e6;
        border-radius: 10px;
        padding: 20px 15px 6px 15px;
        height: 60px;
        font-size: 16px;
        background: #fff;
        transition: all 0.3s ease;
    }

    .floating-input .form-control:focus {
        border-color: #001f3f; /* Navy cuando focused */
        box-shadow: none;
    }

    .floating-input label {
        position: absolute;
        top: 18px;
        left: 15px;
        color: #aaa;
        font-size: 16px;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    /* Efecto flotante cuando:focus o tiene contenido */
    .floating-input .form-control:focus ~ label,
    .floating-input .form-control:not(:placeholder-shown) ~ label {
        top: 6px;
        font-size: 11px;
        color: #001f3f;
        font-weight: 600;
    }

    /* Icono dentro del input */
    .floating-input .input-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .floating-input .form-control:focus ~ .input-icon,
    .floating-input .form-control:not(:placeholder-shown) ~ .input-icon {
        color: #001f3f;
    }

    /* Placeholder vacío para que funcione el selector :not(:placeholder-shown) */
    .floating-input .form-control::placeholder {
        color: transparent;
    }

    /* Botón MINIMALISTA en color NAVY */
    .btn-login {
        border-radius: 10px;
        padding: 15px;
        font-size: 16px;
        font-weight: 600;
        background: #022141; /* Color Navy */
        border: none;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background: #154575; /* Navy más claro al hover */
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 31, 63, 0.3);
    }

    .btn-login:active {
        background: #5ba5f0;
        transform: translateY(0);
    }

    /* Color del icono dentro del botón */
    .btn-login i {
        color: #fff;
    }

    /* Checkbox personalizado */
    .icheck-primary > input:first-child:checked + label::before,
    .icheck-primary > input:first-child:checked:not(:disabled):active + label::before,
    .icheck-primary > input:first-child:checked + input[type="hidden"]:first-child + label::before {
        background-color: #001f3f;
        border-color: #001f3f;
    }

    /* Footer links */
    .login-footer a {
        color: #6c757d;
        font-size: 14px;
    }
    .login-footer a:hover {
        color: #001f3f;
        text-decoration: none;
    }

    /* Título */
    .login-title {
        font-weight: 300;
        color: #343a40;
        margin-bottom: 20px;
    }
    .login-title b {
        font-weight: 700;
    }
</style>
@endpush

{{-- Cabecera --}}
@section('auth_header')
    <h4 class="login-title text-center">
        <b>Iniciar</b> Sesión
    </h4>
@stop

{{-- Cuerpo del formulario --}}
@section('auth_body')
    <form action="{{ route('login') }}" method="POST">
        @csrf

        {{-- Alerta de errores --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Email con Floating Label -->
        <div class="floating-input">
            <input type="email" 
                   name="Email" 
                   class="form-control @error('Email') is-invalid @enderror" 
                   placeholder=" " 
                   value="{{ old('Email') }}" 
                   required 
                   autofocus>
            <label>Correo electrónico</label>
            <span class="input-icon">
                <i class="fas fa-envelope"></i>
            </span>
        </div>

        <!-- Password con Floating Label -->
        <div class="floating-input">
            <input type="password" 
                   name="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   placeholder=" " 
                   required>
            <label>Contraseña</label>
            <span class="input-icon">
                <i class="fas fa-lock"></i>
            </span>
        </div>

        <!-- Recordarme y botón -->
        <div class="row align-items-center mb-4">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" style="font-size: 14px; color: #6c757d;">
                        Recordarme
                    </label>
                </div>
            </div>
            <div class="col-5 text-right">
                <button type="submit" class="btn btn-block btn-login text-white">
                    <i class="fas fa-sign-in-alt"></i>
                </button>
            </div>
        </div>
    </form>
@stop

{{-- Footer --}}
@section('auth_footer')
    <div class="login-footer text-center">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">
                ¿Olvidaste tu contraseña?
            </a>
        @endif
        
        <hr style="margin: 15px 0 10px 0;">
        
        <span style="color: #adb5bd; font-size: 12px;">
            &copy; {{ date('Y') }} Sistema de Matrícula
        </span>
    </div>
@stop
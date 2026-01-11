@extends('adminlte::page')

@section('title', 'Sistema de Matrícula')

@section('content_header')
<div style="
    background-color: #FFFFFF;
    color: black;
    padding: 10px 20px;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
">
    <h1 style="margin: 0; font-size: 1.5rem;">
        Sistema de Gestión Académica
    </h1>

    <div style="text-align: right;">
        <p style="margin: 0;">
            <i class="fas fa-user"></i>
            Bienvenido, {{ Auth::user()->nombre }}!
        </p>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: 5px;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>

            
        </form>
    </div>
</div>
@stop



@section('content')
    @guest
        <!-- Usuario no logueado: mostrar solo login y descripción -->
        <div class="container text-center mt-5">
            <h1>Bienvenido al Sistema de Matrícula</h1>
            <p class="lead">Por favor inicia sesión.</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>

        </div>

 @endguest

    @auth
        <!-- Usuario logueado: mostrar panel completo -->
        <div class="content-wrapper">
            <div class="content-header d-flex justify-content-between align-items-center">
                <h5>Panel de Administrador</h5>
                <!-- Botón de cerrar sesión -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                   
                </form>
            </div>

              
        </div>
             
    @endauth
@stop




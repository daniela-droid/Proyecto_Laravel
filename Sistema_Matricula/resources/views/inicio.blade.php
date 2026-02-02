@extends('adminlte::page')

@section('title', 'Sistema de Matrícula')

@section('content_header')
<div style="
    background-color:#233858;
    color: white;
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

  <!-- Usuario logueado -->
   

@section('content')

<!-- ===== CARRUSEL PRINCIPAL ===== -->
<div class="container my-4">
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <p style="text-align: center;">Panel Administrador.</p>
    <div id="miniCarousel" class="carousel slide mini-carousel" data-bs-ride="carousel">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRUmfhtIMnJnXBPHdHGSiq7atB-msNtORInEw&s" class="d-block w-100" alt="Imagen 1">
            </div>

            <div class="carousel-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHiZJXKX7DDsIrif75mx8R7t-reojQxhSr1g&s" class="d-block w-100" alt="Imagen 2">
            </div>

            <div class="carousel-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRusqfrrgLYEHAIEL9hu6hXHDUz0V2YCvfIIg&s"
                     class="d-block w-100" alt="Imagen 3">
            </div>

        </div>
    </div>
</div>
<!-- ===== FIN CARRUSEL ===== -->


@guest
    <!-- Usuario no logueado -->
    <div class="container text-center mt-4">
        <h1>Bienvenido al Sistema de Matrícula</h1>
        <p class="lead">Por favor inicia sesión.</p>
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
        </a>
    </div>
@endguest


@auth
  
@endauth

@stop
<style>
    .mini-carousel {
  max-width: 420px;
  margin: auto;
}

.mini-carousel img {
  height: 230px;
  object-fit: cover;
  border-radius: 12px;
  
}
</style>



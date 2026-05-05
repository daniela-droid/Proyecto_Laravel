@extends('adminlte::page')

@section('title', 'Cargar Notas')

@section('content_header')
    <div class="container-fluid">
        <h1 class="m-0 text-dark">
            <i class="fas fa-chart-bar mr-2"></i>Cargar Notas
        </h1>
    </div>
@stop

@section('content')
    <div class="container-fluid pt-3">
        @livewire('notas.carga-masiva', ['modo' => 'docente'])
        <a class="btn btn-secondary mt-3" href="{{ url('/mis-estudiantes') }}">volver</a>
    </div>
@stop

@section('js')
<script>
window.addEventListener('alert', event => {
    Swal.fire({
        title: event.detail.message,
        icon: event.detail.type,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar',
    });
});
</script>
@stop

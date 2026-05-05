@extends('adminlte::page')

@section('title', 'Grupo Creado')
@section('plugins.Datatables', true)
@section('css')
<style>
    .confirmacion-card {
        max-width: 600px;
        margin: 50px auto;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .btn-option {
        margin: 10px;
        padding: 15px 30px;
        font-size: 16px;
    }
</style>
@stop

@section('content')
<div class="container">
    <div class="card confirmacion-card">
        <div class="card-header bg-success text-white text-center">
            <h4><i class="fas fa-check-circle"></i> ¡Grupo Creado Exitosamente!</h4>
        </div>
        <div class="card-body text-center">
            <p class="lead">{{ $mensaje }}</p>

            <div class="mt-4">
                <h5>¿Qué deseas hacer ahora?</h5>

                <div class="d-flex justify-content-center flex-wrap">
                    <a href="{{ $rutas['matriculas'] }}" class="btn btn-primary btn-option">
                        <i class="fas fa-plus-circle"></i> {{ $opciones['matriculas'] }}
                    </a>

                    <a href="{{ $rutas['index'] }}" class="btn btn-secondary btn-option">
                        <i class="fas fa-list"></i> {{ $opciones['index'] }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
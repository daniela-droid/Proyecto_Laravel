@extends('adminlte::page')

@section('title', 'Asignaturas')

@section('content_header')
    <h1>Detalles de Asignatura</h1>
@stop

@section('content')
<div class="container">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ $asignatura->nombre }}</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $asignatura->id }}</p>
            <p><strong>Nombre:</strong> {{ $asignatura->nombre }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('asignaturas.edit', $asignatura->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>
@stop

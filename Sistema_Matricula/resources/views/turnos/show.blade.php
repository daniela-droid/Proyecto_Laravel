@extends('adminlte::page')

@section('title', 'Turnos')

@section('content_header')
    <h1>Detalles de Turnos</h1>
@stop

@section('content')
<div class="container">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ $turno->nombre }}</h3>
        </div>
        <div class="card-body">
            <p><strong>id:</strong> {{ $turno->id }}</p>
            <p><strong>Nombre:</strong> {{ $turno->Nombre }}</p>
               <p><strong>Nombre:</strong> {{ $turno->Descripcion}}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('turnos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('turnos.edit', $turno->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>
@stop

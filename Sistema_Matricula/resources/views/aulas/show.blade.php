@extends('adminlte::page')

@section('title', 'Aulas')

@section('content_header')
    <h1>Detalles del Aula seleccionada</h1>
@stop

@section('content')
<div class="container">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ $aula->Nombre }}</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $aula->id }}</p>
            <p><strong>Nombre:</strong> {{ $aula->Nombre }}</p>
             <p><strong>Capacidad:</strong> {{ $aula->Capacidad }}</p>
              
        </div>
        <div class="card-footer">
            <a href="{{ route('aulas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('aulas.edit', $aula->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>
@stop
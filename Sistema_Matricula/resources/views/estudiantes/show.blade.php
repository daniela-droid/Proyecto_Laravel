@extends('adminlte::page')

@section('title', 'Detalle del Estudiante')

@section('content_header')
    <h1>Detalle del Estudiante</h1>
@stop

@section('content')
   
<div class="container">
    <div class="card card-info">
        <div class="card-header">
    
        </div>
        <div class="card-body">
           <p><strong>Nombre:</strong> {{ $estudiante->nombre }}</p>
            <p><strong>Apellido:</strong> {{ $estudiante->apellido }}</p>
            <p><strong>Sexo:</strong> {{ $estudiante->sexo}}</p>
            <p><strong>Cédula:</strong> {{ $estudiante->cedula }}</p>
            <p><strong>Edad:</strong> {{ $estudiante->edad }}</p>
            <p><strong>Celular:</strong> {{ $estudiante->celular }}</p>
            <p><strong>Nombre de la madre:</strong> {{ $estudiante->nombre_madre }}</p>
            <p><strong>Nombre del padre:</strong> {{ $estudiante->nombre_padre }}</p>
            <p><strong>Comarca:</strong> {{ $estudiante->Comarca }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop

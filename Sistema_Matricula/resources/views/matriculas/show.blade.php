@extends('adminlte::page')

@section('title', 'Detalle del las Matriculas')

@section('content_header')
    <h1>Detalle de las Matriculas</h1>
@stop

@section('content')
   
<div class="container">
    <div class="card card-info">
        <div class="card-header">
    
        </div>
        <div class="card-body">
             <p><strong>Id:</strong> {{ $matricula->id}}</p>
           <p><strong>Estudiante:</strong> {{ $matricula->estudiantes->Nombre}}</p>
            <p><strong>Sección:</strong> {{ $matricula->grupos->Descripcion }}</p>
            <p><strong>Periodo:</strong> {{ $matricula->periodos->Nombre }}</p>
           <p><strong>Usuario:</strong> {{ $matricula->usuarios->Email }}</p>
            <p><strong>Fecha de la Matricula:</strong> {{ $matricula->fecha_matricula }}</p>
            <p><strong>Estado de Estudiante:</strong> {{ $matricula->estado }}</p>
            <p><strong>Observación:</strong> {{ $matricula->observaciones }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('matriculas.edit', $matricula->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop
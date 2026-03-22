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
            <p><strong>Código de Persona:</strong>{{$estudiante->Código_Persona}}</p>
           <p><strong>Nombre:</strong> {{ $estudiante->Nombre }}</p>
            <p><strong>Apellido:</strong> {{ $estudiante->Apellido }}</p>
            <p><strong>Sexo:</strong> {{ $estudiante->Sexo}}</p>
             <p><strong>Fecha De Nacimiento:</strong> {{ $estudiante->Fecha_N}}</p>
            <p><strong>Cédula:</strong> {{ $estudiante->Cedula }}</p>
            <p><strong>Edad:</strong> {{ $estudiante->edad }}</p>
            <p><strong>Celular:</strong> {{ $estudiante->Celular }}</p>
            <p><strong>Nombre Padres o Tutor:</strong> {{ $estudiante->id_padre }}</p>
            <p><strong>Comarca:</strong> {{ $estudiante->id_comarca}}</p>
           
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

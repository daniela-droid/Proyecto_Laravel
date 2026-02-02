@extends('adminlte::page')

@section('title', 'Detalle del Docente')

@section('content_header')
    <h1>Detalle del Docente</h1>
@stop

@section('content')
   
<div class="container">
    <div class="card card-info">
        <div class="card-header">
    
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong>{{$docente->Nombre}}</p>
            <p><strong>Apellido:</strong> {{ $docente->Apellido }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $docente->FechadeNacimiento}}</p>
            <p><strong>Gmail:</strong> {{ $docente->Gmail}}</p>
            <p><strong>Telefono:</strong> {{ $docente->Telefono }}</p>
            <p><strong>Especialidad:</strong> {{ $docente->Especialidad}}</p>
            <p><strong>Grupo Asignado:</strong> {{$docente->GrupoAsignado }}</p>
           
        </div>
        <div class="card-footer">
            <a href="{{ route('docentes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('docentes.edit', $docente->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop

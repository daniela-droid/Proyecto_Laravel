@extends('adminlte::page')

@section('title', 'Detalle de la Sección')

@section('content_header')
    <h1>Detalle de la Sección</h1>
@stop

@section('content')
   
<div class="container">
    <div class="card card-info">
        <div class="card-header">
    
        </div>
        <div class="card-body">
            <p><strong>Código:</strong>{{$grupo->Código}}</p>
           <p><strong>Nombre:</strong> {{ $grupo->Nombre}}</p>
            <p><strong>Descripcion:</strong> {{ $grupo->Descripcion }}</p>
             <p><strong>Turno:</strong> {{ $grupo->id_turno}}</p>
            <p><strong>Grado:</strong> {{ $grupo->id_grado }}</p>
            <p><strong>Periodo Académico:</strong>{{$grupo->id_periodo_academicos}}</p>
            
           
        </div>
        <div class="card-footer">
            <a href="{{ route('grupos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop

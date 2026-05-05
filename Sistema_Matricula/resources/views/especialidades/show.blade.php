@extends('adminlte::page')

@section('title', 'Especialidades')

@section('content_header')
    <h1>Detalles de la Especialidad</h1>
@stop

@section('content')
<div class="container">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Especialidad</h3>
        </div>
        <div class="card-body">
            <!-- <p><strong>ID:</strong> {{ $especialidad->id }}</p> -->
            <p><strong>Especialidad:</strong> {{ $especialidad->Especialidad }}</p>
             <p><strong>Descripcion:</strong> {{ $especialidad->Descripcion }}</p>
             
        </div>
        <div class="card-footer">
            <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>

           <a href="{{ route('especialidades.edit', $especialidad->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a> 

        </div>
    </div>
</div>
@stop

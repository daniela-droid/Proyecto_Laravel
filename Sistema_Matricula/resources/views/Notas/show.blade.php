@extends('adminlte::page')

@section('title', 'Detalle del las Notas')

@section('content_header')
    <h1>Detalle de las Notas</h1>
@stop

@section('content')
   
<div class="container">
    <div class="card card-info">
        <div class="card-header">
    
        </div>
        <div class="card-body">
           <p><strong>Id_Estudiantes:</strong> {{ $nota->id_estudiantes }}</p>
            <p><strong>id_Asignaturas:</strong> {{ $nota->id_asignaturas }}</p>
            <p><strong>id_Usuarios:</strong> {{ $nota->id_usuarios }}</p>
            <p><strong>Notas:</strong> {{ $nota->notas }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('notas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('notas.edit', $nota->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop
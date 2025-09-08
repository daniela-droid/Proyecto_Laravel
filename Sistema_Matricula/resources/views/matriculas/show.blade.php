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
           <p><strong>Id_Estudiantes:</strong> {{ $matricula->id_estudiantes }}</p>
            <p><strong>id_Asignaturas:</strong> {{ $matricula->id_asignaturas }}</p>
           
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
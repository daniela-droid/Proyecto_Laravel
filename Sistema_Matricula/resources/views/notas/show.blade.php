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
            <!-- <p><strong>Id de Nota:</strong> {{ $nota->id }}</p> -->
           <p><strong>Matriculas:</strong> {{ $nota->id_matricula }}</p>
            <p><strong>Horarios:</strong> {{ $nota->id_horario }}</p>
            <p><strong>Corte Evaluativo:</strong> {{ $nota->id_corte_evaluativo }}</p>
            <p><strong>Nota:</strong> {{ $nota->nota_normal}}</p>
            <p><strong>Nota Especial:</strong> {{ $nota->nota_especial }}</p>
            <p><strong>Observación:</strong> {{ $nota->Observaciones }}</p>
             <p><strong>Id Usuario:</strong> {{ $nota->id_usuario }}</p>
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
@extends('adminlte::page')

@section('title', 'Cortes')

@section('content_header')
    <h1>Detalles del Corte Evaluativo</h1>
@stop

@section('content')
<div class="container">
    <div class="card card-info">
        <div class="card-header" >
            <h3 class="card-title">Corte Evaluativo</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $corte->id }}</p>
            <p><strong>Modalidad:</strong> {{  $corte->modalidades->nombre}}</p>
             <p><strong>Nombre:</strong> {{ $corte->nombre }}</p>
              <p><strong>Ponderación:</strong> {{ $corte->ponderacion }}</p>
                 <p><strong>Periodo Academico:</strong> {{ $corte->periodos->Nombre}}</p>
            <p><strong>Fecha Inicio:</strong> {{  $corte->fecha_inicio }}</p>
             <p><strong>Fecha Fin:</strong> {{ $corte->fecha_fin }}</p>
            
        </div>
        <div class="card-footer" >
            
            <a href="{{ route('cortes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('cortes.edit', $corte->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>
@stop
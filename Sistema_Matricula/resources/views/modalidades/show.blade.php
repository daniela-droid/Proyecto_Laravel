@extends('adminlte::page')

@section('title', 'Detalle ')

@section('content_header')
    <h1>Detalles de la Modalidad</h1>
@stop

@section('content')
   
<div class="container">
    <div class="card card-info">
        <div class="card-header">
    
        </div>
        <div class="card-body">
        <p><strong>Id:</strong>{{$modalidade->id}}</p>
        <p><strong>Nombre:</strong> {{ $modalidade->nombre }}</p>
        <p><strong>Código :</strong> {{ $modalidade->codigo }}</p>
        <p><strong>Descripción:</strong> {{ $modalidade->descripcion}}</p>
            
           
        </div>
        <div class="card-footer">
            <a href="{{ route('modalidades.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('modalidades.edit', $modalidade->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop

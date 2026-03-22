@extends('adminlte::page')

@section('title', 'Comarcas')

@section('content_header')
    <h1>Detalles de Comarcas</h1>
@stop

@section('content')
<div class="container">
    <div class="card card-info">
        <div class="card-header" >
            <h3 class="card-title">Comarca</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $comarca->id }}</p>
            <p><strong>Comarca:</strong> {{  $comarca->Comarca }}</p>
             <p><strong>Direccion:</strong> {{ $comarca->Direccion }}</p>
            
        </div>
        <div class="card-footer" >
            
            <a href="{{ route('comarcas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('comarcas.edit', $comarca->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>
@stop
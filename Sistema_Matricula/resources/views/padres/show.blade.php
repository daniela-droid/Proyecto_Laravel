@extends('adminlte::page')

@section('title', 'Detalle del Docente')

@section('content_header')
    <h1>Detalle de Los padres o Totores</h1>
@stop

@section('content')
   
<div class="container">
    <div class="card card-info">
        <div class="card-header">
    
        </div>
        <div class="card-body">
            <p><strong>Nombre_o_Tutor</strong>{{$padre->Nombre_o_Tutor}}</p>
            <p><strong>Apellido:</strong> {{ $padre->Apellido }}</p>
         
            <p><strong>Email:</strong> {{ $padre->Email}}</p>

            <p><strong>Cedula:</strong> {{ $padre->Cedula}}</p>
            <p><strong>Telefono:</strong> {{ $padre->Telefono }}</p>
           
        </div>
        <div class="card-footer">
            <a href="{{ route('padres.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('padres.edit', $padre->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop

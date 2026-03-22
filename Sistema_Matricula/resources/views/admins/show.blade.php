@extends('adminlte::page')

@section('title', 'Detalle del Admin')

@section('content_header')
    <h1>Detalle del Docente</h1>
@stop

@section('content')
   
<div class="container">
    <div class="card card-info">
        <div class="card-header">
    
        </div>
        <div class="card-body">

             <p><strong>id_Usuario:</strong>{{$admin->id_usuarios}}</p>
            <p><strong>Nombre:</strong>{{$admin->Nombre}}</p>
            <p><strong>Apellido:</strong> {{ $admin->Apellido }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $admin->Cargo}}</p>
      
           
        </div>
        <div class="card-footer">
            <a href="{{ route('admins.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop

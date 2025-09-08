
@extends('adminlte::page')

@section('title', 'Detalle del Usuario')

@section('content_header')
    <h1>Detalle del Usuario</h1>
@stop

@section('content')
   
<div class="container">
    <div class="card card-info">
        <div class="card-header">
    
        </div>
        <div class="card-body">
           <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
            <p><strong>Gmail:</strong> {{ $usuario->gmail }}</p>
            <p><strong>Password:</strong> {{ $usuario->password}}</p>
            <p><strong>Rol:</strong> {{ $usuario->rol }}</p>
           
        </div>
        <div class="card-footer">
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

@stop
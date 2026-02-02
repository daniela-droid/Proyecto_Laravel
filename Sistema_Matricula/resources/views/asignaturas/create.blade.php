@extends('adminlte::page')

@section('title', 'Asignaturas')

@section('content_header')
    <h1>Lista de Asignaturas</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Agregar Asignatura</div>
        <div class="card-body">
         
            <form action="{{ route('asignaturas.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm w-50" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop

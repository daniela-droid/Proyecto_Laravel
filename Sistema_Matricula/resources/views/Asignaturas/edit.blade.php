@extends('adminlte::page')

@section('title', 'Asignaturas')

@section('content_header')
    <h1>Editar Asignaturas</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">Editar Asignaturas</div>
        <div class="card-body">
            <form action="{{ route('asignaturas.update', $asignatura->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm w-50" value="{{ $asignatura->nombre }}" required>
                </div>

              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
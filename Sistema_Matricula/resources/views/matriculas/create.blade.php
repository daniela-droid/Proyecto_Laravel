@extends('adminlte::page')

@section('title', 'Matriculas')

@section('content_header')
    <h1>Lista de Matriculas</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Agregar Matricula</div>
        <div class="card-body">
         
            <form action="{{ route('matriculas.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}

                <div class="form-group">
                    <label for="id_estudiantes">Id_estudiantes</label>
                    <input type="text" name="id_estudiantes" class="form-control" required>
                </div>

                 <div class="form-group">
                    <label for="id_asignaturas">Id_asignaturas</label>
                    <input type="text" name="id_asignaturas" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop

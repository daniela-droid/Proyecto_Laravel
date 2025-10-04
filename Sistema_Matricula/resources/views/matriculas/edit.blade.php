@extends('adminlte::page')

@section('title', 'Matriculas')

@section('content_header')
    <h1>Editar Matriculas</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">Editar Matriculas</div>
        <div class="card-body">
            <form action="{{ route('matriculas.update', $matricula->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                <div class="form-group">
                    <label for="Id_estudiantes">Id Estudiantes</label>
                    <input type="text" name="id_estudiantes" class="form-control form-control-sm w-50" value="{{ $matricula->id_estudiantes }}" required>
                </div>

                 <div class="form-group">
                    <label for="Id_asignaturas">Id Asignaturas</label>
                    <input type="text" name="id_asignaturas" class="form-control form-control-sm w-50" value="{{ $matricula->id_asignaturas }}" required>
                </div>

              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
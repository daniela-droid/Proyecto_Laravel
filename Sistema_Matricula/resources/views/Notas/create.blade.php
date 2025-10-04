@extends('adminlte::page')

@section('title', 'Notas')

@section('content_header')
    <h1>Lista de Notas</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Agregar Notas</div>
        <div class="card-body">
         
            <form action="{{ route('notas.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}

                <div class="form-group">
                    <label for="id_estudiantes">Id_estudiantes</label>
                    <input type="text" name="id_estudiantes" class="form-control form-control-sm w-50" required>
                </div>

                 <div class="form-group">
                    <label for="id_asignaturas">Id_asignaturas</label>
                    <input type="text" name="id_asignaturas" class="form-control form-control-sm w-50" required>
                </div>
                 <div class="form-group">
                    <label for="id_usuarios">Id_Usuarios</label>
                    <input type="text" name="id_usuarios" class="form-control form-control-sm w-50" required>
                </div>
<div class="form-group">
                <label for="nota">Nota:</label>
    <input type="number" name="notas" id="notas" step="0.01" min="0" max="100" required>
  </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('notas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop

@extends('adminlte::page')

@section('title', 'Editar Estudiante')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Editar Estudiante</div>
        <div class="card-body">
            <form action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm w-50" value="{{ $estudiante->nombre }}" required>
                </div>

                <div class="form-group">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="apellido" class="form-control form-control-sm w-50" value="{{ $estudiante->apellido }}" required>
                </div>

                <div class="form-group">
                    <label for="Sexo">Sexo</label>
                    <select name="sexo" class="form-control form-control-sm w-50" required>
                        <option value="F" {{ $estudiante->sexo == 'F' ? 'selected' : '' }}>F</option>
                        <option value="M" {{ $estudiante->sexo == 'M' ? 'selected' : '' }}>M</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Cedula">Cédula</label>
                    <input type="text" name="cedula" class="form-control form-control-sm w-50" value="{{ $estudiante->cedula }}" required>
                </div>

                <div class="form-group">
                    <label for="Edad">Edad</label>
                    <input type="number" name="edad" class="form-control form-control-sm w-50" value="{{ $estudiante->edad }}" required>
                </div>

                <div class="form-group">
                    <label for="Celular">Celular</label>
                    <input type="number" name="celular" class="form-control form-control-sm w-50" value="{{ $estudiante->celular }}" required>
                </div>

                <div class="form-group">
                    <label for="Nombre_Madre">Nombre Madre</label>
                    <input type="text" name="nombre_madre" class="form-control form-control-sm w-50" value="{{ $estudiante->nombre_madre }}" required>
                </div>

                <div class="form-group">
                    <label for="Nombre_Padre">Nombre Padre</label>
                    <input type="text" name="nombre_padre" class="form-control form-control-sm w-50" value="{{ $estudiante->nombre_padre }}" required>
                </div>

                <div class="form-group">
                    <label for="Comarca">Comarca</label>
                    <input type="text" name="comarca" class="form-control form-control-sm w-50" value="{{ $estudiante->comarca }}" required>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

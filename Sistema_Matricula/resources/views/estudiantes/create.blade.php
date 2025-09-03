@extends('adminlte::page')

@section('title', 'Agregar Estudiante')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Agregar Estudiante</div>
        <div class="card-body">
            <form action="{{ route('estudiantes.store') }}" method="POST">
                @csrf {{-- seguridad de laravel --}}

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="apellido" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="Sexo">Sexo</label>
                    <select name="sexo" class="form-control" required>
                        <option value="F">F</option>
                        <option value="M">M</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Cedula">Cédula</label>
                    <input type="text" name="cedula" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="Edad">Edad</label>
                    <input type="number" name="edad" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="Celular">Celular</label>
                    <input type="number" name="celular" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="Nombre_Madre">Nombre Madre</label>
                    <input type="text" name="nombre_madre" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="Nombre_Padre">Nombre Padre</label>
                    <input type="text" name="nombre_padre" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="Comarca">Comarca</label>
                    <input type="text" name="comarca" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

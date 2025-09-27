@extends('adminlte::page')

@section('title', 'Agregar Estudiante')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Estudiante</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('estudiantes.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}

                <div class="form-group mb-2">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                       <label for="nombre">Apellido</label>
                    <input type="text" name="apellido" class="form-control form-control-sm w-50" required>
                </div>

                

                <div class="form-group mb-2"> 
                    <label for="Sexo">Sexo</label>
                 <select name="sexo" class="form-control form-control-sm w-50" required> 
                    <option value="F">F</option> <option value="M">M</option> </select>
                 </div>

                <div class="form-group mb-2">
                    <label for="cedula">Cédula</label>
                    <input type="text" name="cedula" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="edad">Edad</label>
                    <input type="number" name="edad" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                      <label for="nombre">Celular</label>
                    <input type="text" name="celular" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="nombre_madre">Nombre Madre</label>
                    <input type="text" name="nombre_madre" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="nombre_padre">Nombre Padre</label>
                    <input type="text" name="nombre_padre" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-3">
                    <label for="comarca">Comarca</label>
                    <input type="text" name="comarca" class="form-control form-control-sm w-50" required>
                </div>

                
                   <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

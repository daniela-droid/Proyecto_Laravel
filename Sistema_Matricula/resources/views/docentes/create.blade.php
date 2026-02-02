@extends('adminlte::page')

@section('title', 'Agregar Docentes')

@section('content')
<div class="container">
    <div class="card shadow-sm">
      <!--  <div class="card-header bg-green text-white">-->
            <div style="background-color: #17a2b8; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Docente</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('docentes.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}


                <div class="form-group mb-2">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                       <label for="FechadeNacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="FechadeNacimiento"  class="form-control form-control-sm w-50" required>
                </div>

                

                <div class="form-group mb-2"> 
                    <label for="Gmail">Gmail</label>
                     <input type="text" name="Gmail" class="form-control form-control-sm w-50" required>
              
                   </div>

                <div class="form-group mb-2">
                    <label for="Telefono">Telefono</label>
                    <input type="text" name="Telefono" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="Especialidad">Especialidad</label>
                    <input type="text" name="Especialidad" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                      <label for="GrupoAsignado">Grupo Asignado</label>
                    <input type="text" name="GrupoAsignado" class="form-control form-control-sm w-50" required>
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

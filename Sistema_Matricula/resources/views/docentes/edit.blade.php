@extends('adminlte::page')

@section('title', 'Editar Docentes')

@section('content')
<div class="container">
    <div class="card">
        <div style="background-color: #17a2b8; color: white; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Editar Docente</div>
        <div class="card-body">
            <form action="{{ route('docentes.update', $docente->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                  <div class="form-group mb-2">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" value="{{$docente->Nombre}}"required>
                </div>


                <div class="form-group">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control form-control-sm w-50" value="{{ $docente->Apellido }}" required>
                </div>

                <div class="form-group mb-2">
                       <label for="FechadeNacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="FechadeNacimiento"  class="form-control form-control-sm w-50" value="{{$docente->FechadeNacimiento}}"required>
                </div>

                   <div class="form-group mb-2"> 
                    <label for="Gmail">Gmail</label>
                     <input type="text" name="Gmail" class="form-control form-control-sm w-50" value="{{$docente->Gmail}}"required>
              
                   </div>

              <div class="form-group mb-2">
                    <label for="Telefono">Telefono</label>
                    <input type="text" name="Telefono" class="form-control form-control-sm w-50" value="{{$docente->Telefono}}" required>
                </div>

                   <div class="form-group mb-2">
                    <label for="Especialidad">Especialidad</label>
                    <input type="text" name="Especialidad" class="form-control form-control-sm w-50" value="{{$docente->Especialidad}}"required>
                </div>

                <div class="form-group mb-2">
                      <label for="GrupoAsignado">Grupo Asignado</label>
                    <input type="text" name="GrupoAsignado" class="form-control form-control-sm w-50" value="{{$docente->GrupoAsignado}}"required>
                </div>

                

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

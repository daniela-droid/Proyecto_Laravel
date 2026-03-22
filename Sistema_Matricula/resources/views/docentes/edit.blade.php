@extends('adminlte::page')

@section('title', 'Editar Docentes')

@section('content')
<div class="container">
    <div class="card">
               <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
        <div class="card-header">Editar Docente</div>
        <div class="card-body">
            <form action="{{ route('docentes.update', $docente->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                        <select name="id_usuario" class="form-control form-control-sm w-50" required>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ $docente->id_usuario == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->Email }}
                                    </option>
                                @endforeach
</select>

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
                    <label for="Email">Email</label>
                     <input type="text" name="Email" class="form-control form-control-sm w-50" value="{{$docente->Email}}"required>
              
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
                <label for="id_especialidads">Especialidades</label>
                <select name="id_especialidads" class="form-control form-control-sm w-50" required>
                 
                    <option value="" disabled selected>-- Especialiades --</option>
                    @foreach($especialidads as $especialidad)
                        {{-- Importante: value lleva el ID, pero el usuario ve el Nombre --}}
                        <option value="{{ $especialidad->id }}">{{ $especialidad->Especialidad}} </option>
                    @endforeach
                </select>
              
            </div>
                

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

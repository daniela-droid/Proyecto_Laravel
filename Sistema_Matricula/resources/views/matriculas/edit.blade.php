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

               
                <div class="form-group mb-3">
                <label for="id_estudiante"> Estudiantes</label>
                <select name="id_estudiante" class="form-control form-control-sm w-50" required>
                  @foreach($estudiantes as $estudiante)
                       <option value="{{$estudiante->id }}"{{$matricula->id_estudiante == $estudiante->id ? 'selected' : ''}}
                       >{{ $estudiante->Nombre }}</option>
                    @endforeach
                </select>
            </div>

             <div class="form-group mb-3">
                <label for="id_grupo"> Secciones</label>
                <select name="id_grupo" class="form-control form-control-sm w-50" required>
                    @foreach($grupos as $grupo)
                <option value="{{$grupo->id }}" {{$matricula->id_grupo == $grupo->id ? 'selected' : ''}}
                       >{{ $grupo->Descripcion }}</option>
                    @endforeach
                </select>
            </div>

             <div class="form-group mb-3">
                <label for="id_periodo_academicos">Periodos Academicos</label>
                <select name="id_periodo_academicos" class="form-control form-control-sm w-50" required>
                    @foreach($periodos as $periodo)
                       <option value="{{$periodo->id }}" {{$matricula->id_periodo_academicos == $periodo->id ? 'selected' : ''}}
                       >{{$periodo->Nombre }}</option>
                    @endforeach
                </select>
            </div>
           
            
            <div class="form-group mb-3">
                <label for="id_usuario">Usuarios</label>
                <select name="id_usuario" class="form-control form-control-sm w-50" required>
                   @foreach($usuarios as $usuario)
                       <option value="{{$usuario->id }}" {{$matricula->id_usuario==$usuario->id ? 'selected': ''}}
                       >{{ $usuario->Email }}</option>
                    @endforeach
                </select>
            </div>

             <div class="form-group mb-2">
                    <label for="fecha_matricula">Fecha</label>
                    <input type="date" name="fecha_matricula" class="form-control form-control-sm w-50" value="{{$matricula->fecha_matricula}}"required>
            </div>

             <div class="form-group mb-2"> 
                    <label for="">Estado</label>
                 <select name="estado" class="form-control form-control-sm w-50" value="{{$matricula->estado}}"required> 
                    <option value="Activo">Activo</option> 
                    <option value="Retirado">Retirado</option> 
                    <option value="Suspendido">Suspendido</option> 
                    <option value="Expulsado">Expulsado</option> 
                </select>
                 </div>

                 <div class="form-group mb-2">
                    <label for="observaciones">Observaciones</label>
                    <input type="text" name="observaciones" class="form-control form-control-sm w-50" value="{{$matricula->observaciones}}" required>
                </div>

              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
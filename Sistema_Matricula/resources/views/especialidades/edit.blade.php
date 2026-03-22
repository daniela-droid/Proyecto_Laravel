@extends('adminlte::page')

@section('title', 'Especialidad')

@section('content_header')
    <h1>Editar Especialidades</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">Editar Especialidades</div>
        <div class="card-body">
            <form action="{{ route('especialidades.update', $especialidad->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                
                 <div class="form-group">
                    <label for="Especialidad">Especialidades</label>
                    <input type="text" name="Especialidad" class="form-control form-control-sm w-50" value="{{$especialidad->Especialidad}}"required>
                </div>


                <div class="form-group">
                    <label for="Descripcion">Descripcion</label>
                    <input type="text" name="Descripcion" class="form-control form-control-sm w-50" value="{{$especialidad->Descripcion}}" required>
                </div>

              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
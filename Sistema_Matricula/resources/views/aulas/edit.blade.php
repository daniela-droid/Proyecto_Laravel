@extends('adminlte::page')

@section('title', 'Aulas')

@section('content_header')
    <h1>Editar Aulas</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
         <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Editar Aula</div>
        <div class="card-body">
            <form action="{{ route('aulas.update', $aula->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

               <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" value="{{$aula->Nombre}}"required>
                </div>

                     <div class="form-group">
                    <label for="Capacidad">Capacidad</label>
                    <input type="text" name="Capacidad" class="form-control form-control-sm w-50" value="{{$aula->Capacidad}}"required>
                </div>

              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('aulas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
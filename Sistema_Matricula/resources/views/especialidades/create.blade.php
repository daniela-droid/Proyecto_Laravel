@extends('adminlte::page')

@section('title', 'Especialidades')

@section('content_header')
    <h1>Lista de Especialidades</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header"  style="background-color:#233858; color:white">Agregar Especialidades</div>
        <div class="card-body">
         
            <form action="{{ route('especialidades.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}

                <div class="form-group">
                    <label for="Especialidad">Especialidades</label>
                    <input type="text" name="Especialidad" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group">
                    <label for="Descripcion">Descripcion</label>
                    <input type="text" name="Descripcion" class="form-control form-control-sm w-50" required>
                </div>
                
                
                <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Cancelar</a>
                  <a href="{{ route('docentes.create') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i>ir a Docente</a>
                
            </form>
        </div>
    </div>
</div>
@stop
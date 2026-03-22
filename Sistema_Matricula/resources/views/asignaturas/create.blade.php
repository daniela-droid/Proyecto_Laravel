@extends('adminlte::page')

@section('title', 'Asignaturas')

@section('content_header')
    <h1>Asignaturas</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header"  style="background-color:#233858; color:white">Agregar Asignatura</div>
        <div class="card-body">
         
            <form action="{{ route('asignaturas.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" required>
                </div>

                     <div class="form-group">
                    <label for="Descripcion">Descripcion</label>
                    <input type="text" name="Descripcion" class="form-control form-control-sm w-50" required>
                </div>
                 <div class="form-group">
                    <label for="Código">Código</label>
                    <input type="text" name="Código" class="form-control form-control-sm w-50" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop

@extends('adminlte::page')

@section('title', 'Turnos')

@section('content_header')
    <h1>Lista de Turnos</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Agregar Turno</div>
        <div class="card-body">
         
            <form action="{{ route('turnos.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" required>
                </div>

                 <div class="form-group">
                    <label for="Descripcion">Descripcion</label>
                    <input type="text" name="Descripcion" class="form-control form-control-sm w-50" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
               
                <a href="{{ route('turnos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop

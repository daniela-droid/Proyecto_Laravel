@extends('adminlte::page')

@section('title', 'Aulas')

@section('content_header')
    <h1>Lista de Aulas</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header" style="background-color:#233858; color:white" >Agregar Aulas</div>
        <div class="card-body">
         
            <form action="{{ route('aulas.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" required>
                </div>

                     <div class="form-group">
                    <label for="Capacidad">Capacidad</label>
                    <input type="text" name="Capacidad" class="form-control form-control-sm w-50" required>
                </div>
                
                
                <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('aulas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop

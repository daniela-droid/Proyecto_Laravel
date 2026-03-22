@extends('adminlte::page')

@section('title', 'Comarcas')

@section('content_header')
    <h1>Lista de Comarcas</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Agregar Comarca</div>
        <div class="card-body">
         
            <form action="{{ route('comarcas.store') }}" method="POST">
                @csrf {{-- método de seguridad --}}

                <div class="form-group">
                    <label for="Comarca">Comarca</label>
                    <input type="text" name="Comarca" class="form-control form-control-sm w-50" required>
                </div>

                     <div class="form-group">
                    <label for="Direccion">Direccion</label>
                    <input type="text" name="Direccion" class="form-control form-control-sm w-50" required>
                </div>
                
                
                <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('comarcas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop

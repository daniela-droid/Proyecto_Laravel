@extends('adminlte::page')
@section('title','Periodos Academicos')

@section('content_header')
<h2>Nuevo Periodo Academico</h2>
@stop

@section('content')

<div class="container">
    <div class="card">
        
        <div class="card-header">Inserte un Nuevo Periodo</div>
        <div class="card-body">

        <form action="{{route('periodo.store')}} " method="POST">
            @csrf {{-- Seguridad de Laravel --}}

       <div class="form-group mb-2">
        <label for="Nombre">Nombre</label>
        <input type="text" name="Nombre"   class="form-control form-control-sm w-50" required>
       </div>

       <div class="form-group mb-2">
        <label for="Fecha_inicio">Fecha_inicio</label>
        <input type="date" name="Fecha_inicio"  class="form-control form-control-sm w-50" required>
       </div>


       <div class="form-group mb-2">
        <label for="Fecha_fin">Fecha_fin</label>
        <input type="date" name="Fecha_fin"  class="form-control form-control-sm w-50" required>
       </div>

    <label for="Activo">Activo</label>
     <select name="Activo" class="form-control form-control-sm w-50" required>
    <option value="1" {{ old('Activo') == '1' ? 'selected' : '' }}>Sí (Activo)</option>
    <option value="0" {{ old('Activo') == '0' ? 'selected' : '' }}>No (Inactivo)</option>
    </select>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{route('periodo.index')}}" class="btn btn-secondary">cancelar</a>
        </form>

        </div>
        
    </div>
</div>









@stop
@extends('adminlte::page')

@section('title', 'Periodos Escolares')

@section('content_header')
    <h1>Editar Periodo Escolar</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
         <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Editar Periodo</div>
        <div class="card-body">
            <form action="{{ route('periodo.update', $periodo->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

               <div class="form-group mb-2">
                <label for="Nombre">Nombre</label>
                <input type="text" name="Nombre"   class="form-control form-control-sm w-50" value='{{$periodo->Nombre}}'required>
            </div>

        <div class="form-group mb-2">
            <label for="Fecha_inicio">Fecha_inicio</label>
            <input type="date" name="Fecha_inicio"  class="form-control form-control-sm w-50" value='{{$periodo->Fecha_inicio}}'required>
       </div>


        <div class="form-group mb-2">
            <label for="Fecha_fin">Fecha_fin</label>
            <input type="date" name="Fecha_fin"  class="form-control form-control-sm w-50" value='{{$periodo->Fecha_fin}}'required>
        </div>

          <label for="Activo">Activo</label>
     <select name="Activo" class="form-control form-control-sm w-50" value='{{$periodo->Activo}}' required>
    <option value="1" {{ old('Activo') == '1' ? 'selected' : '' }}>Sí (Activo)</option>
    <option value="0" {{ old('Activo') == '0' ? 'selected' : '' }}>No (Inactivo)</option>
    </select>



              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('periodo.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
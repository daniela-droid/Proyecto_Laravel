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
            <form class="edit-form" action="{{ route('periodo.update', $periodo->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion --}}

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Nombre">Nombre</label>
                            <input type="text" name="Nombre" class="form-control form-control-sm" value="{{ $periodo->Nombre }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Fecha_inicio">Fecha Inicio</label>
                            <input type="date" name="Fecha_inicio" class="form-control form-control-sm" value="{{ $periodo->Fecha_inicio }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Fecha_fin">Fecha Fin</label>
                            <input type="date" name="Fecha_fin" class="form-control form-control-sm" value="{{ $periodo->Fecha_fin }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Activo">Activo</label>
                            <select name="Activo" class="form-control form-control-sm" required>
                                <option value="1" {{ $periodo->Activo == '1' ? 'selected' : '' }}>Sí (Activo)</option>
                                <option value="0" {{ $periodo->Activo == '0' ? 'selected' : '' }}>No (Inactivo)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('periodo.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
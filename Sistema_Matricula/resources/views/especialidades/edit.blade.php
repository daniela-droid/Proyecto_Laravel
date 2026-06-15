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
            <form class="edit-form" action="{{ route('especialidades.update', $especialidad->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion --}}

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Especialidad">Especialidades</label>
                            <input type="text" name="Especialidad" class="form-control form-control-sm" value="{{ $especialidad->Especialidad }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Descripcion">Descripcion</label>
                            <input type="text" name="Descripcion" class="form-control form-control-sm" value="{{ $especialidad->Descripcion }}" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
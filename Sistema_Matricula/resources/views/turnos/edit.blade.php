@extends('adminlte::page')

@section('title', 'Turnos')

@section('content_header')
    <h1>Editar los Turnos</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
             <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Agregar Turno</div>
        <div class="card-body">
         
            <form class="edit-form"  action="{{ route('turnos.update', $turno->id) }}" method="POST">
                @csrf {{-- método de seguridad --}}
                 @method('PUT') {{-- Actualizacion--}}

                 <div class="row">
                    <div class="col-md-4">
                         <div class="form-group">
                            <label for="Nombre">Nombre</label>
                            <input type="text" name="Nombre" class="form-control " value="{{$turno->Nombre}}"required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Descripcion">Descripcion</label>
                            <input type="text" name="Descripcion" class="form-control " value="{{$turno->Descripcion}}" required>
                        </div>
                    </div>
                 </div>
               
                    <hr>
              

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('turnos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop

@extends('adminlte::page')

@section('title', 'Comarcas')

@section('content_header')
    <h1>Editar Comarca</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
         <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Editar Comarca</div>
        <div class="card-body">
            <form class="edit-form"  action="{{ route('comarcas.update', $comarca->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                <div class="row">
                    <div class="col-md-4">
                          <div class="form-group">
                                <label for="Comarca">Comarca</label>
                                <input type="text" name="Comarca" class="form-control "value="{{$comarca->Comarca}}" required>
                            </div>
                    </div>
                    <div class="col-md-4">

                     <div class="form-group">
                    <label for="Direccion">Direccion</label>
                    <input type="text" name="Direccion" class="form-control "value="{{$comarca->Direccion}}" required>
                </div>
                    </div>
                </div>
              
                <hr>

              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('comarcas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
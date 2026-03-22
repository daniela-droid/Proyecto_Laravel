@extends('adminlte::page')

@section('title', 'Editar  Modalidades')

@section('content')
<div class="container">
    <div class="card">
               <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
        <div class="card-header">Editar Modalidades</div>
        <div class="card-body">
            <form action="{{ route('modalidades.update', $modalidade->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                     
                <div class="form-group mb-2">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm w-50" value="{{$modalidade->nombre}}" required>
                </div>

                <div class="form-group mb-2">
                    <label for="codigo">Código</label>
                    <input type="text" name="codigo" class="form-control form-control-sm w-50" value="{{$modalidade->codigo}}" required>
                </div>

                <div class="form-group mb-2">
                       <label for="descripcion">Descripción</label>
                    <input type="text" name="descripcion"  class="form-control form-control-sm w-50" value="{{$modalidade->descripcion}}" required>
                </div>

                 

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('modalidades.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

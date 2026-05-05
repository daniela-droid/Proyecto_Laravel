@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1>Editar Reporte</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">Editar Reporte</div>
        <div class="card-body">
            <form action="{{ route('reportesadm.update', $reporte->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

             

                <div class="form-group mb-3">
                    <label for="titulo">Título de Reporte:</label>
                    <input type="text" name="titulo" id="titulo" class="form-control form-control-sm w-50" value="{{$reporte->titulo}}"  required>
                </div>


                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" class="form-control form-control-sm w-50" rows="3" required>{{ $reporte->descripcion }}</textarea>
                </div>
                <!-- <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" name="descripcion"  class="form-control form-control-sm w-50"  value="{{$reporte->descripcion}}" required>
                </div> -->

                
             <div class="form-group mb-3"> 
                    <label for="">Categoría</label>
                 <select name="categoria" class="form-control form-control-sm w-50" value="{{$reporte->categoria}}"required> 
                    <option value="sistema">Sistema</option> 
                    <option value="infraestructura">Infraestructura</option> 
                    <option value="personal">Personal</option> 
                    <option value="otros">Otros</option> 
                </select>
            </div>

             <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('reportesadm.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
             
        </div>
    </div>
</div>
@stop
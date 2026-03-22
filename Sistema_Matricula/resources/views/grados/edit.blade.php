@extends('adminlte::page')
@section('title','Grados')

@section('content_header')
<h1>Editar Grados</h1>
@stop

@section('content')

<div class="container">
 
<div class="card">
       <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
<div class="card-header">Editar Grados</div>
<div class="card-body">
<form action="{{ route('grados.update', $grado->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}
        <div class="form-group">
        <label for="Nombre">Nombre</label>
        <input type="text" name="Nombre" class="form-control form-control-sm w-50" value="{{$grado->Nombre}}"required>
        </div>

        <div class="form-group">
        <label for="Nivel">Nivel</label>
        <input type="text" name="Nivel" class="form-control form-control-sm w-50"value="{{$grado->Nivel}}" required >
        </div>




<button type="submit" class="btn btn-success">Editar</button>
<a href="{{route('grados.index')}} " class="btn btn-secondary">Cancerlar</a>
</form>
</div>
</div>
</div>




@stop
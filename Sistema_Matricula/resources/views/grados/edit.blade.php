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
        <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                        <label for="Nombre">Nombre</label>
                        <input type="text" name="Nombre" class="form-control " value="{{$grado->Nombre}}"required>
                        </div>
                </div>
                <div class="col-md-4">

                <div class="form-group">
                <label for="Nivel">Nivel</label>
                <input type="number" name="Nivel" class="form-control "value="{{$grado->Nivel}}" required >
                </div>

                </div>
                <div class="col-md-4">
                 <div class="form-group">
                <label for="tipo_nivel">Tipo de Nivel</label>
                <select name="tipo_nivel" id="tipo_nivel" class="form-control" required>
                        <option value="Primaria" {{ $grado->tipo_nivel == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                        <option value="Secundaria" {{ $grado->tipo_nivel == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                </select>
                </div>
                </div>
                 </div>

          <div class="row">
                <div class="col-md-12">
                        <hr>
                </div>
                <div class="col-md-4">
                         <button type="submit" class="btn btn-success">Editar</button>
                <a href="{{route('grados.index')}} " class="btn btn-secondary">Cancerlar</a>   
                </div>
          
        </div>
      


</form>
</div>
</div>
</div>




@stop
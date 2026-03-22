@extends('adminlte::page')
@section('title','grados')

@section('content_header')
<h1>Lista de Grados</h1>
@stop


@section('content')


<div class="container">

<div class="card"> 

<div class="card-header" >Agregar Grados</div>
<div class="card-body">

<form action="{{route('grados.store')}}"  method="POST">
 @csrf {{-- método de seguridad --}}

 <div class="form-group">
<label for="Nombre">Nombre</label>
<input type="text" name="Nombre" class="form-control form-control-sm w-50" required>
 </div>

 <div class="form-group">
<label for="Nivel">Nivel</label>
<input type="text" name="Nivel" class="form-control form-control-sm w-50" required >
 </div>

 <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{route('grados.index')}} " class="btn btn-secondary">Cancelar</a>


</form>


</div>

</div>
</div>




@stop
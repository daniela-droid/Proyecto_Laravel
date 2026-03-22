@extends('adminlte::page')
@section('title','Grados')

@section('content_header')
<h1>Lista de Grados</h1>
@stop

@section('content')

<div class="container">
      <div class="card card-info">
        <div class="card-header  ">
            <h3 class="card-title">Grado</h3>
        </div>

        <div class="card-body">
           <p><strong>Id Grado:</strong>{{$grado->id}} </p>
           <p><strong>Nombre:</strong> {{$grado->Nombre}}</p>
           <p><strong>Nivel:</strong> {{$grado->Nivel}}</p>

        </div>

        <div class="card-footer">

            <a href="{{route('grados.index')}} 
            " class="btn btn-secondary">
         <i class="fas fa-arrow-left"></i> Volver</a>
            
            
            <a href="{{route('grados.edit',$grado->id)}}" class="btn btn-warning">
                 <i class="fas fa-edit"></i> Editar
            </a>

        </div>

    </div>
</div>






@stop
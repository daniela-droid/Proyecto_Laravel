@extends('adminlte::page')
@section('title','Periodos')
@section('content_header')
<h1>Detalles</h1>
@stop
@section('content')

<div class="container">
    <div class="card card-info">
        <div class="card-header"></div>
            <div class="card-body">

                <p><strong>ID:</strong> {{$periodo->id}}</p>
                <p><strong>Nombre:</strong>{{$periodo->Nombre}}   </p>
                <p><strong>Fecha Inicial:</strong>{{$periodo->Fecha_fin }}  </p>
                <p><strong>Fecha Fin:</strong>  {{$periodo-> Fecha_fin}} </p>
                 <p><strong>Actividad del ciclo Escolar:</strong> {{$periodo->Activo}}  </p>


            </div>

            <div class="card-footer">
                <a href="{{route('periodo.index')}}" class="btn btn-secondary">
                    <i class="class fa fa-arrow-left"> </i> Volver</a>
                <a href="{{route('periodo.edit',$periodo->id)}}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>Editar</a>
            </div>
    </div>
</div>




@stop
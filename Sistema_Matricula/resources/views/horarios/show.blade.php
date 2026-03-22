@extends('adminlte::page')
@section('title','Horario')
@section('content_header')
<h3>Horario</h3>
@stop


@section('content')

<div class="container">
<div class="card">
    <div class="card-info">
    <div class="card-header">
    
    </div>
        <div class="card-body">
        <p><strong>ID:</strong>{{$horario->id}}</p>
        <p><strong>Grupo:</strong>{{$horario->id_grupo}}</p>
        <p><strong>Asignatura:</strong>{{$horario->id_asignatura}}</p>
        <p><strong>Docente:</strong>{{$horario->id_docente}}</p>
        <p><strong>Aula:</strong>{{$horario->id_aula}}</p>
        <p><strong>Dia de Semana:</strong>{{$horario->Dia_semana}}</p>
        <p><strong>Hora de Inicio:</strong>{{$horario->Hora_inicio}}</p>
        <p><strong>Hora de Culminar:</strong>{{$horario->Hora_fin}}</p>

        </div>
        <div class="card-footer">
         <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>

        </div>
</div>
</div>



@stop
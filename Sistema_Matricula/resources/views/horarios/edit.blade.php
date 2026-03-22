@extends('adminlte::page')
@section('title','Horarios')
@section('content_header')
<h3>Editar Horario</h3>
@stop

@section('content')

<div class="container">
    <div class="card">
         <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
        <div class="card-header">Editar Este Horario</div>
        <div class="card-body">
            <form action="{{route('horarios.update',$horario->id)}}" method="POST">
                @csrf
                @method('PUT')

                 <div class="form-group mb-2">
                <label for="id_grupo">Grupos</label>
                <select name="id_grupo" class="form-control form-control-sm w-50" required>
                    @foreach($grupo as $grupo)
                        <option value="{{ $grupo->id }}" 
                            {{ $horario->id_grupo == $grupo->id ? 'selected' : '' }}>
                            {{ $grupo->Nombre }}
                        </option>
                    @endforeach
                </select>
            </div>


                     <div class="form-group mb-2">
                <label for="id_asignatura">Asignaturas</label>
                <select name="id_asignatura" class="form-control form-control-sm w-50" required>
                    @foreach($asignatura as $asignatura)
                        <option value="{{ $asignatura->id }}" 
                            {{ $horario->id_asignatura == $asignatura->id ? 'selected' : '' }}>
                            {{ $asignatura->Nombre }}
                        </option>
                    @endforeach
                </select>
            </div>


                     <div class="form-group mb-2">
                <label for="id_docente"> Docentes</label>
                <select name="id_docente" class="form-control form-control-sm w-50" required>
                    @foreach($docente as $docente)
                         <option value="{{ $docente->id }}"  {{ $horario->id_docente == $docente->id ?
                            'selected': ''}}> {{$docente->Nombre}}</option>
                    @endforeach
                </select>
               </div>


                     <div class="form-group mb-2">
                <label for="id_aula">Aulas</label>
                <select name="id_aula" class="form-control form-control-sm w-50" required>
                    @foreach($aula as $aula)
                         <option value="{{ $aula->id }}" {{$horario->id_aula == $aula->id ? 'selected':''}} > 
                            {{ $aula->Nombre }} </option>
                    @endforeach
                </select>
               </div>

                

             <div class="form-group mb-2"> 
                    <label for="Dia_semana">Dia de Semana</label>
                 <select name="Dia_semana" class="form-control form-control-sm w-50" value="{{$horario->Dia_semana}}"required> 
                    <option value="Lunes">Lunes</option> 
                    <option value="Martes">Martes</option>
                    <option value="Miercoles">Miercoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                    <option value="Sabado">Sabado</option>
                </select>
                 </div>


                 <div class="form-group mb-2">
               <label for="Hora_inicio">Hora de Inicio</label>
                 <input type="time" name="Hora_inicio"style="background-color:lightblue" class="form-control form-control-sm w-50" value="{{$horario->Hora_inicio}}" required>
                    </div>
                  <div class="form-group mb-2">
                 <label for="Hora_fin">Hora de Culminacion</label>
                 <input type="time" name="Hora_fin" style="background-color:lightblue"class="form-control form-control-sm w-50" value="{{$horario->Hora_fin}}"required>
                </div>


                 <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Cancelar</a>


            </form>

        </div>
    </div>
</div>







@stop
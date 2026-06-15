@extends('adminlte::page')

@section('title', 'Notas')

@section('content_header')
    <h1>Editar Usuarios</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">Editar Notas</div>
        <div class="card-body">
            <form class="edit-form"  action="{{ route('notas.update', $nota->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                
               
                 <div class="form-group mb-3">
                <label for="id_matricula"> Matriculas</label>
                <select name="id_matricula" class="form-control form-control-sm w-50" required>
               @foreach($matriculas as $matricula)
                       <option value="{{$matricula->id }}" {{$nota->id_matricula == $matricula->id ? 'selected' : ''  }}
                       >{{$matricula->id  }} </option>
                    @endforeach
                </select>
            </div>

             <div class="form-group mb-3">
                <label for="id_horario"> Horario</label>
                <select name="id_horario" class="form-control form-control-sm w-50" required>
                  @foreach($horarios as $horario)
                       <option value="{{$horario->id }}" {{$nota->id_horarios == $horario->id ? 'selected' : ''}}
                       >{{$horario->id }}</option>
                    @endforeach
                </select>
            </div>
                
             <div class="form-group mb-3">
                <label for="id_corte_evaluativo"> Cortes Evaluativos</label>
                <select name="id_corte_evaluativo" class="form-control form-control-sm w-50" required>
                   @foreach($cortes as $corte)
                       <option value="{{$corte->id }}"{{$nota->id_corte_evaluativo == $corte->id ? 'selected' : ''}}
                       >{{$corte->nombre }}</option>
                    @endforeach
                </select>
            </div>
                
 

                <div class="form-group">
                        <label for="nota_normal">Nota:</label>
                    <input type="number" step="any" name="nota_normal" id="notas" class="form-control form-control-sm w-50" placeholder="0.00" value="{{$nota->nota_normal}}" required>
                </div>

                 <div class="form-group">
                        <label for="nota_especial">Nota Especial:</label>
                    <input type="number"  step="any" name="nota_especial" id="notas" class="form-control form-control-sm w-50" placeholder="0.00" value="{{$nota->nota_especial}}"  required>
                </div>

                <div class="form-group">
                        <label for="observacion">Observaciones:</label>
                    <input type="text" name="observacion" id="notas" class="form-control form-control-sm w-50" value="{{$nota->observacion}}"  required>
                </div>


              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('notas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
@extends('adminlte::page')

@section('title', 'Editar Sección')

@section('content')
<div class="container">
    <div class="card">
          <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
        <div class="card-header">Editar Sección</div>
        <div class="card-body">
            <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

              
                <div class="form-group mb-2">
                    <label for="Código">Código</label>
                    <input type="text" name="Código" class="form-control form-control-sm w-50" value="{{$grupo->Código}}"required>
                </div>

                <div class="form-group mb-2">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control form-control-sm w-50" value="{{$grupo->Nombre}}"required>
                </div>

                <div class="form-group mb-2">
                       <label for="Descripcion">Descripcion</label>
                    <input type="text" name="Descripcion" class="form-control form-control-sm w-50" value="{{$grupo->Descripcion}}"required>
                </div>


                <div class="form-group mb-2">
                <label for="id_turno">Turnos</label>
                <select name="id_turno" class="form-control form-control-sm w-50" required>
                 @foreach($turnos as $turno)
                         <option value="{{ $turno->id }}"{{ $grupo->id_turno == $turno->id ? 'selected' : ''}}
                           > {{$turno->id }} {{$turno->Nombre }}
                         </option>
                    @endforeach
                </select>
            </div>

              

                <div class="form-group mb-3">
                <label for="id_grado">Grados</label>
                <select name="id_grado" class="form-control form-control-sm w-50" required>
                   @foreach($grados as $grado)
                       <option value="{{ $grado->id }}"{{ $grupo->id_grado == $grado->id ? 'selected' : ''}} > {{$grado->id}} {{$grado->Nombre}}
                     </option>
                    @endforeach
                </select>
            </div>


                 <div class="form-group mb-3">
                <label for="id_periodo_academicos">Periodo Académico</label>
                <select name="id_periodo_academicos" class="form-control form-control-sm w-50" required>
                      @foreach($periodos as $periodo)
                   <option value="{{ $periodo->id }}"
                    {{ $grupo->id_periodo_academicos == $periodo->id ? 'selected' : '' }}
                    > {{$periodo->id}} {{$periodo->Nombre}}
                </option>
                    @endforeach
                </select>
            </div>


                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

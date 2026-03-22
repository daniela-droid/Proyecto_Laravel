@extends('adminlte::page')

@section('title', 'Comarcas')

@section('content_header')
    <h1>Editar</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
         <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Editar Corte Evaluativo</div>
        <div class="card-body">
            <form action="{{ route('cortes.update', $corte->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                 <div class="form-group mb-2">
                <label for="id_modalidades">Modalidades</label>
                <select name="id_modalidades" class="form-control form-control-sm w-50" required>
                 @foreach($modalidades as $modalidade)
                         <option value="{{ $modalidade->id }}"{{$corte->id_modalidades == $modalidade->id ? 'selected' : ''}}
                         >{{ $modalidade->id}} {{ $modalidade->nombre }}</option>
                    @endforeach
                </select>
              
            </div>


                <div class="form-group mb-2">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm w-50" value="{{$corte->nombre}}" required>
                </div>


                <div class="form-group mb-2">
                       <label for="ponderacion">Ponderación</label>
                    <input type="text" name="ponderacion" class="form-control form-control-sm w-50"  value="{{$corte->ponderacion}}" required>
                </div>

                
                <div class="form-group mb-2">
                <label for="id_periodo_academicos">Periodos Academicos</label>
                <select name="id_periodo_academicos" class="form-control form-control-sm w-50" required>
                 @foreach($periodos as $periodo)
                         <option value="{{ $periodo->id }}"{{$corte->id_periodo_academicos == $periodo->id ? 'selected' : ''}}
                         >{{ $periodo->id}} {{ $periodo->Nombre }}</option>
                    @endforeach
                </select>
              
            </div>

              
                 <div class="form-group mb-2">
                       <label for="fecha_inicio">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control form-control-sm w-50"  value="{{$corte->fecha_inicio}}" required>
                </div>
               
                  <div class="form-group mb-2">
                       <label for="fecha_fin">Fecha Fin</label>
                    <input type="date" name="fecha_fin" class="form-control form-control-sm w-50"  value="{{$corte->fecha_fin}}"  required>
                </div>

               
              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('cortes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
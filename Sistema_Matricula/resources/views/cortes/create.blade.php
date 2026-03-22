@extends('adminlte::page')

@section('title', 'Agregar ')

@section('content')
<div class="container">
    <div class="card shadow-sm">
     <!--   <div class="card-header bg-dark text-white">-->
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Corte Evaluativo</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('cortes.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}


                 <div class="form-group mb-2">
                <label for="id_modalidades">Modalidades</label>
                <select name="id_modalidades" class="form-control form-control-sm w-50" required>
                  <option value="" disabled selected>-- Seleccione --</option>
                    @foreach($modalidades as $modalidade)
                         <option value="{{ $modalidade->id }}">{{ $modalidade->id}} {{ $modalidade->nombre }}</option>
                    @endforeach
                </select>
              
            </div>


                <div class="form-group mb-2">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm w-50" required>
                </div>


                <div class="form-group mb-2">
                       <label for="ponderacion">Ponderación</label>
                    <input type="text" name="ponderacion" class="form-control form-control-sm w-50" required>
                </div>

                
                <div class="form-group mb-2">
                <label for="id_periodo_academicos">Periodos Academicos</label>
                <select name="id_periodo_academicos" class="form-control form-control-sm w-50" required>
                  <option value="" disabled selected>-- Seleccione--</option>
                    @foreach($periodos as $periodo)
                         <option value="{{ $periodo->id }}">{{ $periodo->id}} {{ $periodo->Nombre }}</option>
                    @endforeach
                </select>
              
            </div>

              
                 <div class="form-group mb-2">
                       <label for="fecha_inicio">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control form-control-sm w-50" required>
                </div>
               
                  <div class="form-group mb-2">
                       <label for="fecha_fin">Fecha Fin</label>
                    <input type="date" name="fecha_fin" class="form-control form-control-sm w-50" required>
                </div>

                
                   <button type="submit" class="btn btn-primary">Guardar</button>
                
                <a href="{{ route('cortes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

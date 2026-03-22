@extends('adminlte::page')

@section('title', 'Agregar Modalidad')

@section('content')
<div class="container">
    <div class="card shadow-sm">
      <!--  <div class="card-header bg-green text-white">-->
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Modalidad</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('modalidades.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}

          

                <div class="form-group mb-2">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="codigo">Código</label>
                    <input type="text" name="codigo" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                       <label for="descripcion">Descripción</label>
                    <input type="text" name="descripcion"  class="form-control form-control-sm w-50" required>
                </div>

                
                   <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('modalidades.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

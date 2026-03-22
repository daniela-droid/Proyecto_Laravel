@extends('adminlte::page')

@section('title', 'Agregar Padres')

@section('content')
<div class="container">
    <div class="card shadow-sm">
      <!--  <div class="card-header bg-green text-white">-->
            <div style="background-color: #233858; color: white; padding: 10px 20px; border-radius: 5px;">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Padres</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('padres.store') }}" method="POST">
                @csrf {{-- Seguridad de Laravel --}}


                <div class="form-group mb-2">
                    <label for="Nombre_o_Tutor">Nombre o Tutor</label>
                    <input type="text" name="Nombre_o_Tutor" class="form-control form-control-sm w-50" required>
                </div>

                <div class="form-group mb-2">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control form-control-sm w-50" required>
                </div>

            

                <div class="form-group mb-2"> 
                    <label for="Email">Email</label>
                     <input type="text" name="Email" class="form-control form-control-sm w-50" required>
              
                </div>
                
                <div class="form-group mb-2"> 
                    <label for="Cedula">Cedula</label>
                     <input type="text" name="Cedula" class="form-control form-control-sm w-50" required>
              
                   </div>

                <div class="form-group mb-2">
                    <label for="Telefono">Telefono</label>
                    <input type="text" name="Telefono" class="form-control form-control-sm w-50" required>
                </div>

            
                
                   <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- Aquí estaba mal, debe ser route() con comillas --}}
                <a href="{{ route('padres.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

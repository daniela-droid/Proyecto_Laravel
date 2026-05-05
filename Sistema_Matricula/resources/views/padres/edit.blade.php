@extends('adminlte::page')

@section('title', 'Editar Docentes')

@section('content')
<div class="container">
    <div class="card">
        <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Editar Padres</div>
        <div class="card-body">
            <form action="{{ route('padres.update', $padre->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}

                

                 <div class="form-group mb-2">
                    <label for="Nombre_o_Tutor">Nombre o Tutor</label>
                    <input type="text" name="Nombre_o_Tutor" class="form-control form-control-sm w-50" value="{{$padre->Nombre_o_Tutor}}" required>
                </div>

                <div class="form-group mb-2">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" class="form-control form-control-sm w-50" value="{{$padre->Apellido}}" required>
                </div>

            

                <div class="form-group mb-2"> 
                    <label for="Email">Email</label>
                     <input type="Email" name="Email" class="form-control form-control-sm w-50" value="{{$padre->Email}}"required>
              
                   </div>
                
                <div class="form-group mb-2"> 
                    <label for="Cedula">Cedula</label>
                     <input type="text" name="Cedula" class="form-control form-control-sm w-50" value="{{$padre->Cedula}}"required>
              
                   </div>

                <div class="form-group mb-2">
                    <label for="Telefono">Telefono</label>
                    <input type="text" name="Telefono" class="form-control form-control-sm w-50" value="{{$padre->Telefono}}"required>
                </div>

                

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('padres.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
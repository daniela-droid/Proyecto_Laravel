@extends('adminlte::page')

@section('title', 'Asignaturas')

@section('content_header')
    <h1>Editar Asignaturas</h1>
@stop

@section('content')
    <div class="container">
    <div class="card">
         <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Editar Asignaturas</div>
        <div class="card-body">
            <form class="edit-form"  action="{{ route('asignaturas.update', $asignatura->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion--}}
                <div class="row">

                <div class="col-md-4">
               <div class="form-group">
    <label for="Nombre">Nombre</label>
    <select name="Nombre" class="form-control" id="asignaturaSelect" required>
        <option value="">-- Seleccione Asignaturas--</option>
            
            <option value="Lengua y Literatura" {{ $asignatura->Nombre == 'Lengua y Literatura' ? 'selected' : '' }}>Lengua y Literatura</option>
            <option value="Matemática" {{ $asignatura->Nombre == 'Matemática' ? 'selected' : '' }}>Matemática</option>
            
            <option value="Ciencias Naturales" {{ $asignatura->Nombre == 'Ciencias Naturales' ? 'selected' : '' }}>Ciencias Naturales</option>
            <option value="Estudios Sociales" {{ $asignatura->Nombre == 'Estudios Sociales' ? 'selected' : '' }}>Estudios Sociales</option>
            <option value="Educación Física" {{ $asignatura->Nombre == 'Educación Física' ? 'selected' : '' }}>Educación Física</option>
            <option value="Taller de Arte y Cultura" {{ $asignatura->Nombre == 'Taller de Arte y Cultura' ? 'selected' : '' }}>Taller de Arte y Cultura</option>
         <option value="Inglés" {{ $asignatura->Nombre == 'Inglés' ? 'selected' : '' }}>Inglés</option>
            <option value="A.E.P" {{ $asignatura->Nombre == 'A.E.P' ? 'selected' : '' }}>A.E.P</option>
            {{-- Nota: Conservé tus atributos 'value' exactos del create para que coincidan con tu base de datos --}}
            <option value="Educación Física" {{ $asignatura->Nombre == 'Educación Física' ? 'selected' : '' }}>Educación Artistica</option>
            <option value="Formación Personal y Ciudadana" {{ $asignatura->Nombre == 'Formación Personal y Ciudadana' ? 'selected' : '' }}>Danza</option>
            <option value="Computación" {{ $asignatura->Nombre == 'Computación' ? 'selected' : '' }}>Derecho de la mujer</option>
            <option value="Creciendo en Valores" {{ $asignatura->Nombre == 'Creciendo en Valores' ? 'selected' : '' }}>Creciendo en Valores</option>
            <option value="Conociendo mi mundo" {{ $asignatura->Nombre == 'Conociendo mi mundo' ? 'selected' : '' }}>Conociendo mi mundo</option>
        </select>
    </div>

                </div>

                <div class="col-md-4">
                      <div class="form-group">
                    <label for="Descripcion">Descripcion</label>
                    <input type="text" name="Descripcion" class="form-control " value="{{ $asignatura->Descripcion }}"required>
                </div>
                </div>
                <div class="col-md-4">
                      <div class="form-group">
                    <label for="Código">Código</label>
                    <input type="text" name="Código" class="form-control " value="{{ $asignatura->Código }}"required>
                </div>
                </div>

                 
               
            </div>
            <hr>
              <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('asignaturas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
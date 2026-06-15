@extends('adminlte::page')

@section('title', 'Editar Docentes')

@section('content')
<div class="container">
    <div class="card">
               <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px; ">
        <div class="card-header">Editar Docente</div>
        <div class="card-body">
            <form class="edit-form" action="{{ route('docentes.update', $docente->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion --}}

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="id_usuario">Usuario</label>
                            <select name="id_usuario" class="form-control form-control-sm" required>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ $docente->id_usuario == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->id }} {{ $usuario->Email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Nombre">Nombre</label>
                            <input type="text" name="Nombre" class="form-control form-control-sm" value="{{ $docente->Nombre }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Apellido">Apellido</label>
                            <input type="text" name="Apellido" class="form-control form-control-sm" value="{{ $docente->Apellido }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="FechadeNacimiento">Fecha de Nacimiento</label>
                            <input type="date" name="FechadeNacimiento" class="form-control form-control-sm" value="{{ $docente->FechadeNacimiento }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Email">Email</label>
                            <input type="text" name="Email" class="form-control form-control-sm" value="{{ $docente->Email }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Telefono">Telefono</label>
                            <input type="text" name="Telefono" id="Telefono" class="form-control form-control-sm @error('Telefono') is-invalid @enderror" value="{{ old('Telefono', $docente->Telefono) }}" pattern="\+505[0-9]{8}" maxlength="12" placeholder="+50512345678" required>
                            @error('Telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="id_especialidads">Especialidades</label>
                            <select name="id_especialidads" class="form-control form-control-sm" required>
                                @foreach($especialidads as $especialidad)
                                    <option value="{{ $especialidad->id }}" {{ $docente->id_especialidads == $especialidad->id ? 'selected' : '' }}>
                                        {{ $especialidad->id }} {{ $especialidad->Especialidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const telefonoInput = document.getElementById('Telefono');

    telefonoInput?.addEventListener('input', function() {
        let value = this.value.replace(/[^\d+]/g, '');
        if (!value.startsWith('+505')) {
            value = '+505' + value.replace(/^\+?505?/, '');
        }
        this.value = value.slice(0, 12);
    });
});
</script>
@stop

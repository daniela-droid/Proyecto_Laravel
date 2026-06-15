@extends('adminlte::page')

@section('title', 'Editar Docentes')

@section('content')
<div class="container">
    <div class="card">
        <div style="background-color: #e0e5ee; color: dark; padding: 10px 20px; border-radius: 5px;">
        <div class="card-header">Editar Padres</div>
        <div class="card-body">
            <form class="edit-form" action="{{ route('padres.update', $padre->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Actualizacion --}}

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Nombre_o_Tutor">Nombre o Tutor</label>
                            <input type="text" name="Nombre_o_Tutor" class="form-control form-control-sm" value="{{ $padre->Nombre_o_Tutor }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Apellido">Apellido</label>
                            <input type="text" name="Apellido" class="form-control form-control-sm" value="{{ $padre->Apellido }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Email">Email</label>
                            <input type="email" name="Email" class="form-control form-control-sm" value="{{ $padre->Email }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Cedula">Cedula</label>
                            <input type="text" name="Cedula" id="Cedula" class="form-control form-control-sm text-uppercase @error('Cedula') is-invalid @enderror" value="{{ old('Cedula', $padre->Cedula) }}" required pattern="[0-9]{13}[A-Z]" maxlength="14" placeholder="5662811021000F">
                            @error('Cedula')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="Telefono">Telefono</label>
                            <input type="text" name="Telefono" id="Telefono" class="form-control form-control-sm @error('Telefono') is-invalid @enderror" value="{{ old('Telefono', $padre->Telefono) }}" required pattern="\+505[0-9]{8}" maxlength="12" placeholder="+50512345678">
                            @error('Telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('padres.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cedulaInput = document.getElementById('Cedula');
    const telefonoInput = document.getElementById('Telefono');

    cedulaInput?.addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/[^0-9A-Z]/g, '').slice(0, 14);
    });

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

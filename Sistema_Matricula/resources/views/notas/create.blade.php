@extends('adminlte::page')


<!-- dejar asi o se duplica -->
@section('content')
    <div class="container-fluid pt-3">
        {{-- ESTA ES LA ÚNICA LÍNEA QUE DEBE EXISTIR --}}
        @livewire('notas.carga-masiva', ['modo' => 'admin'])
        <a class="btn btn-secondary" href="{{route('notas.index')}}">volver</a>
    </div>
 
@stop
@section('js')
<script>
window.addEventListener('alert', event => {
    Swal.fire({
        title: event.detail.message,
        icon: event.detail.type,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fas fa-list"></i> Ir al Listado',
        cancelButtonText: '<i class="fas fa-plus"></i> Cargar otro grupo',
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el profesor quiere ir al Index
            window.location.href = "{{ route('notas.index') }}";
        }
        // Si cancela, se queda en la página actual para seguir trabajando
    });
});
</script>
@stop

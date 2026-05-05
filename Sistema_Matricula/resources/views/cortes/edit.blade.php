@extends('adminlte::page')

@section('title', 'Comarcas')
@section('plugins.Datatables', true)
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
                        <div class="input-group w-50">
                            <input type="hidden" name="id_modalidades" id="id_modalidades"value="{{$corte->id_modalidades}}" required>
                            
                            <input type="text" id="nombre_m_display" class="form-control form-control-sm" value="{{$corte->modalidades->nombre}}"  readonly required>
                            
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalm">
                                    <i class="fas fa-search "></i> Buscar
                                </button>
                              <a href="{{route('modalidades.create')}}" class="btn btn-sm btn-primary ms-1 ml-2">  <i class="fas fa-plus"></i></a>
                            </div>
                         
                         </div>
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
    @include('components.modal_cortes_mod')
@stop
@section('js')
<script>
     function seleccionarm(id, nombreCompleto) {
                        $('#id_modalidades').val(id);
                        $('#nombre_m_display').val(nombreCompleto);
                        $('#modalm').modal('hide');
                    }

                    $(document).ready(function() {
                        // Inicializar DataTable
                        var table = $('#tabla_m_modal').DataTable({
                            "responsive": true,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                            }
                        });

                        // Activar el foco en el buscador al abrir el modal
                        $('#modalm').on('shown.bs.modal', function () {
                            $(this).find('input[type="search"]').focus();
                        });
                    });
</script>
@stop
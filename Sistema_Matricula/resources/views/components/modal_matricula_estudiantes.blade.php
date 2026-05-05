<div class="modal fade" id="modalstu" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Seleccionar Estudiantes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover datatable" id="tabla_stu_modal">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                           <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($estudiantes as $e)
                <tr>
                    <td>
                        {{ $e->Nombre }}
                        {{-- Si el conteo de matriculas es mayor a 0, mostramos que ya está --}}
                        @if($e->matriculas->count() > 0)
                            <span class="badge badge-danger">Ya Matriculado</span>
                        @endif
                    </td>
                    <td>
                        @if($e->matriculas->count() > 0)
                            {{-- Botón deshabilitado para evitar duplicados --}}
                            <button type="button" class="btn btn-sm btn-secondary" disabled>
                                <i class="fas fa-lock"></i>
                            </button>
                        @else
                            {{-- Botón activo si no tiene ninguna matrícula --}}
                            <button type="button" class="btn btn-sm btn-success" 
                                onclick="seleccionarEstu('{{ $e->id }}', '{{$e->Nombre }}')">
                                <i class="fas fa-check"></i> Seleccionar
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach
                 </tbody>
                </table>
                <div class="mt-3 text-right">
                    <a href="{{ route('estudiantes.create', ['from' => 'matriculas']) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Agregar Estudiante
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
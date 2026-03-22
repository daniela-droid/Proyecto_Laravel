<div class="modal fade" id="modalespecialidad" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Seleccionar Especialidades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover datatable" id="tabla_especialidades_modal">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                           <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($especialidads as $d)
                        <tr>
                            <td>{{ $d->Especialidad }} </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success" 
                                    onclick="seleccionarEspecialidades('{{ $d->id }}', '{{$d->Especialidad }} ')">
                                    <i class="fas fa-check"></i> Seleccionar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
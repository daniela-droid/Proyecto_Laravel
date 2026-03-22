<div class="modal fade" id="modalBuscarPadre" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Seleccionar Padre o Tutor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover datatable" id="tabla_padres_modal">
                    <thead>
                        <tr>
                            <th>Nombre y Apellido</th>
                            <th>Parentesco</th> <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($padre as $p)
                        <tr>
                            <td>{{ $p->Nombre_o_Tutor }} {{ $p->Apellido }}</td>
                            <td><span class="badge badge-secondary">{{ $p->Parentesco ?? 'Tutor' }}</span></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success" 
                                    onclick="seleccionarPadre('{{ $p->id }}', '{{ $p->Nombre_o_Tutor }} {{ $p->Apellido }}')">
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
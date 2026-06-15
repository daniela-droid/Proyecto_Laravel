<div class="modal fade" id="modaluser" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title">Seleccionar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong>Usuarios disponibles</strong>
                    </div>
                    <div>
                        <a href="{{ route('usuarios.create', ['from' => 'docentes']) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-user-plus"></i> Agregar nuevo usuario
                        </a>
                    </div>
                </div>
                <table class="table table-striped table-hover datatable" id="tabla_user_modal">
                    <thead>
                        <tr>
                            <th>Email</th>
                           <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $u)
                        <tr>
                            <td>{{ $u->Email }} </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success" 
                                    onclick="seleccionaruser('{{ $u->id }}', '{{$u->Email }} ')">
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
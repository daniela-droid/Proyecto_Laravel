<div class="modal fade" id="modalturno" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title">Seleccionar Turnos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3" id="pills-turno-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-buscar-turno-tab" data-toggle="pill" href="#pills-buscar-turno" role="tab" aria-controls="pills-buscar-turno" aria-selected="true">
                            <i class="fas fa-search"></i> Buscar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-nuevo-turno-tab" data-toggle="pill" href="#pills-nuevo-turno" role="tab" aria-controls="pills-nuevo-turno" aria-selected="false">
                            <i class="fas fa-plus"></i> Agregar Nuevo
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-buscar-turno" role="tabpanel" aria-labelledby="pills-buscar-turno-tab">
                        <table class="table table-striped table-hover datatable" id="tabla_turno_modal">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                   <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($turnos as $t)
                                <tr>
                                    <td>{{ $t->Nombre }} </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" 
                                            onclick="seleccionarturnos('{{ $t->id }}', '{{$t->Nombre}} ')">
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-nuevo-turno" role="tabpanel" aria-labelledby="pills-nuevo-turno-tab">
                        <form id="formTurnoRapido">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Nombre</label>
                                    <input type="text" name="Nombre" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Descripción</label>
                                    <input type="text" name="Descripcion" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success btn-sm px-4" onclick="agregarTurnoNuevo()">
                                        <i class="fas fa-plus"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
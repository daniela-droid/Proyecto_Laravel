<div class="modal fade" id="modalm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title">Seleccionar Modalidades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3" id="pills-modalidad-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-buscar-modalidad-tab" data-toggle="pill" href="#pills-buscar-modalidad" role="tab" aria-controls="pills-buscar-modalidad" aria-selected="true">
                            <i class="fas fa-search"></i> Buscar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-nuevo-modalidad-tab" data-toggle="pill" href="#pills-nuevo-modalidad" role="tab" aria-controls="pills-nuevo-modalidad" aria-selected="false">
                            <i class="fas fa-plus"></i> Agregar Nueva
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-buscar-modalidad" role="tabpanel" aria-labelledby="pills-buscar-modalidad-tab">
                        <table class="table table-striped table-hover datatable" id="tabla_m_modal">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                   <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modalidades as $d)
                                <tr>
                                    <td>{{ $d->nombre }} </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" 
                                            onclick="seleccionarm('{{ $d->id }}', '{{$d->nombre}} ')">
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-nuevo-modalidad" role="tabpanel" aria-labelledby="pills-nuevo-modalidad-tab">
                        <form id="formModalidadRapido">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label small fw-bold">Nombre</label>
                                    <input type="text" name="nombre" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label small fw-bold">Código</label>
                                    <input type="text" name="codigo" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label small fw-bold">Descripción</label>
                                    <textarea name="descripcion" class="form-control form-control-sm" rows="3" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success btn-sm px-4" onclick="agregarModalidadNueva()">
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

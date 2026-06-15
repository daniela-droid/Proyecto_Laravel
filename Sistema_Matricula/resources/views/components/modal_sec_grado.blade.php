<div class="modal fade" id="modalgrado" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title">Seleccionar Grados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3" id="pills-grado-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-buscar-grado-tab" data-toggle="pill" href="#pills-buscar-grado" role="tab" aria-controls="pills-buscar-grado" aria-selected="true">
                            <i class="fas fa-search"></i> Buscar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-nuevo-grado-tab" data-toggle="pill" href="#pills-nuevo-grado" role="tab" aria-controls="pills-nuevo-grado" aria-selected="false">
                            <i class="fas fa-plus"></i> Agregar Nuevo
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-buscar-grado" role="tabpanel" aria-labelledby="pills-buscar-grado-tab">
                        <table class="table table-striped table-hover datatable" id="tabla_grado_modal">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                   <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grados as $g)
                                <tr>
                                    <td>{{ $g->Nombre }} </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" 
                                            onclick="seleccionargrados('{{ $g->id }}', '{{$g->Nombre}} ')">
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-nuevo-grado" role="tabpanel" aria-labelledby="pills-nuevo-grado-tab">
                        <form id="formGradoRapido">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small fw-bold">Nombre</label>
                                    <input type="text" name="Nombre" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small fw-bold">Nivel</label>
                                    <input type="number" name="Nivel" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small fw-bold">Tipo de Nivel</label>
                                    <select name="tipo_nivel" class="form-control form-control-sm" required>
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Primaria">Primaria</option>
                                        <option value="Secundaria">Secundaria</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success btn-sm px-4" onclick="agregarGradoNuevo()">
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
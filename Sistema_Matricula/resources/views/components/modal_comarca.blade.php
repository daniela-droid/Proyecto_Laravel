<div class="modal fade" id="modalBuscarcomarca" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title"> Gestión de Comarcas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Pestañas -->
                <ul class="nav nav-pills mb-3" id="pills-comarca-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-buscar-com-tab" data-toggle="pill" href="#pills-buscar-com">
                            <i class="fas fa-search"></i> Buscar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-nuevo-com-tab" data-toggle="pill" href="#pills-nuevo-com">
                            <i class="fas fa-plus"></i> Agregar Nueva
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!--  PESTAÑA 1: BÚSQUEDA -->
                    <div class="tab-pane fade show active" id="pills-buscar-com">
                        <table class="table table-sm table-striped table-hover datatable w-100" id="tabla_com_modal">
                            <thead>
                                <tr>
                                    <th>Comarca</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comarca as $c)
                                <tr>
                                    <td><strong>{{ $c->Comarca }}</strong></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" 
                                            onclick="seleccionarcom('{{ $c->id }}', '{{ $c->Comarca }}')">
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!--  PESTAÑA 2: AGREGAR NUEVA -->
                    <div class="tab-pane fade" id="pills-nuevo-com">
                        <form id="formComarcaRapido">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold">Nombre Comarca</label>
                                    <input type="text" name="Comarca" class="form-control form-control-sm" required>
                                </div>
    
                                     <div class="col-md-8">
                                    <label class="form-label small fw-bold">Dirección</label>
                                    <input type="text" name="Direccion" class="form-control form-control-sm" required>
                                      </div>
                                <div class="col-md-4 align-self-end">
                                    <button type="button" onclick="agregarComarcaNueva()" 
                                        class="btn btn-success btn-sm px-4">
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

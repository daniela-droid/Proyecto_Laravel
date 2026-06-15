<div class="modal fade" id="modalasig" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title">Gestión de Asignaturas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Pestañas -->
                <ul class="nav nav-pills mb-3" id="pills-asig-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-buscar-asig-tab" data-toggle="pill" href="#pills-buscar-asig">
                            <i class="fas fa-search"></i> Buscar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-nuevo-asig-tab" data-toggle="pill" href="#pills-nuevo-asig">
                            <i class="fas fa-plus"></i> Agregar Nueva
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!--  PESTAÑA 1: BÚSQUEDA -->
                    <div class="tab-pane fade show active" id="pills-buscar-asig">
                        <table class="table table-striped table-hover datatable" id="tabla_asig_modal">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asignatura as $a)
                                <tr>
                                    <td>{{ $a->Nombre }} </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" 
                                            onclick="seleccionarAsig('{{ $a->id }}', '{{$a->Nombre}} ')">
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!--  PESTAÑA 2: AGREGAR NUEVA -->
                    <div class="tab-pane fade" id="pills-nuevo-asig">
                        <form id="formAsignaturaRapido">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nombre</label>
                                    <input type="text" name="Nombre" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Código</label>
                                    <input type="text" name="Código" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Descripción</label>
                                    <textarea name="Descripcion" class="form-control form-control-sm" rows="3" required></textarea>
                                </div>
                                <div class="col-md-12 align-self-end">
                                    <button type="button" onclick="agregarAsignaturaNueva()" 
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
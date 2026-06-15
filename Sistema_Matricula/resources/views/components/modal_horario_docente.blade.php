<div class="modal fade" id="modaldoc" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title">Gestión de Docentes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3" id="pills-docente-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-buscar-doc-tab" data-toggle="pill" href="#pills-buscar-doc">
                            <i class="fas fa-search"></i> Buscar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-nuevo-doc-tab" data-toggle="pill" href="#pills-nuevo-doc">
                            <i class="fas fa-plus"></i> Agregar Nuevo
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-buscar-doc">
                        <table class="table table-striped table-hover datatable" id="tabla_doc_modal">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($docente as $d)
                                <tr>
                                    <td>{{ $d->Nombre }} </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success"
                                            onclick="seleccionarDocentes('{{ $d->id }}', '{{$d->Nombre}} ')">
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="pills-nuevo-doc">
                        <div class="alert alert-info">
                            Para agregar un docente nuevo, serás redirigido al formulario de docentes.
                        </div>
                        <a href="{{ route('docentes.create', ['from' => 'horarios']) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-right"></i> Ir a Agregar Docente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalsec" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title">Gestión de Secciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3" id="pills-sec-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-buscar-sec-tab" data-toggle="pill" href="#pills-buscar-sec">
                            <i class="fas fa-search"></i> Buscar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-nuevo-sec-tab" data-toggle="pill" href="#pills-nuevo-sec">
                            <i class="fas fa-plus"></i> Agregar Nuevo
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-buscar-sec">
                        <table class="table table-striped table-hover datatable" id="tabla_sec_modal">
                            <thead>
                                <tr>
                                    <th>Grados</th>
                                    <th>Nombre</th>
                                    <th>Turno</th>
                                   <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grupo as $g)
                                <tr>
                                    <td>{{$g->grados->Nombre ?? ''}}</td>
                                    <td>{{ $g->Descripcion }} </td>
                                    <td>{{ $g->turnos->Nombre ?? '' }}</td>
                                  
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" 
                                            onclick='seleccionarGrupos(@json($g->id), @json(trim($g->Descripcion . " - " . ($g->grados?->Nombre ?? "Sin grado") . " - " . ($g->turnos?->Nombre ?? "Sin turno"))))'>
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="pills-nuevo-sec">
                        <div class="alert alert-info">
                            Para agregar una sección nueva, serás redirigido al formulario de secciones.
                        </div>
                        <a href="{{ route('grupos.create', ['from' => 'horarios']) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-right"></i> Ir a Agregar Sección
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

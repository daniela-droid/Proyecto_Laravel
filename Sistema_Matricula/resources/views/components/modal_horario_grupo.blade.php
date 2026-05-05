<div class="modal fade" id="modalsec" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title">Seleccionar Secciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                                    onclick="seleccionarGrupos('{{ $g->id }}', '{{$g->Descripcion}}  ', '{{$g->grados->Nombre}}', '{{$g->turnos->Nombre}}')">
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
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
                <!-- Botón para agregar nueva sección -->
                <div class="mb-3">
                    <button type="button" class="btn btn-primary btn-sm" onclick="agregarNuevaSeccion()">
                        <i class="fas fa-plus"></i> Agregar Sección
                    </button>
                </div>
                
                <table class="table table-striped table-hover datatable" id="tabla_sec_modal">
                    <thead>
                        <tr>
                            <th>Grados</th>
                            <th>Tipo</th>
                            <th>Seccion</th>
                           <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $g)
                        <tr>
                            <td>{{$g->grados->Nombre ?? ''}}</td>
                            <td>{{$g->grados->tipo_nivel ?? ''}}</td>
                            <td>{{ $g->Descripcion }} </td>
                           
                            <td>
                                <button type="button" class="btn btn-sm btn-success" 
                                    onclick="seleccionarGrupos('{{ $g->id }}', '{{$g->Descripcion}} ')">
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

<script>
function agregarNuevaSeccion() {
    // Cerrar el modal actual
    $('#modalsec').modal('hide');
    // Redirigir a grupos.create con parámetro from=matriculas
    window.location.href = '{{ route("grupos.create") }}?from=matriculas';
}
</script>
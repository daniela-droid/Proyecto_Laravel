<div class="modal fade" id="modalBuscarPadre" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title">  Padres/Tutores</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Pestañas -->
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-buscar-tab" data-toggle="pill" href="#pills-buscar">
                            <i class="fas fa-search"></i> Buscar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-nuevo-tab" data-toggle="pill" href="#pills-nuevo">
                            <i class="fas fa-user-plus"></i> Agregar Nuevo
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!--  PESTAÑA 1: BÚSQUEDA (tu tabla actual) -->
                    <div class="tab-pane fade show active" id="pills-buscar">
                        <table class="table table-sm table-striped table-hover datatable w-100" id="tabla_padres_modal">
                            <thead>
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>Parentesco</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($padre as $p)
                                <tr>
                                    <td><strong>{{ $p->Nombre_o_Tutor }} {{ $p->Apellido }}</strong></td>
                                    <td><span class="badge badge-info">{{ $p->Parentesco ?? 'Tutor' }}</span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success btn-seleccionar-padre" data-id="{{ $p->id }}" data-nombre="{{ $p->Nombre_o_Tutor }} {{ $p->Apellido }}">
                                            <i class="fas fa-check"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!--  PESTAÑA 2: AGREGAR NUEVO -->
                    <div class="tab-pane fade" id="pills-nuevo">
                        <form id="formPadreRapido">
                            @csrf
                            <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold">Nombre</label>
                                        <input type="text" name="Nombre_o_Tutor" class="form-control " required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Apellido</label>
                                        <input type="text" name="Apellido" class="form-control " required>
                                    </div>
                                     <div class="col-md-4">
                                          <label class="form-label small fw-bold">Email</label>
                                        <input name="Email" type="email" class="form-control ">
                                    </div>
                                         </div>
                                         <div class="row">
                                    <div class="col-md-4">
                                        <label class="small">Cédula</label>
                                        <input name="Cedula" class="form-control text-uppercase input-cedula-padre" pattern="[0-9]{13}[A-Z]" maxlength="14" placeholder="5662811021000F">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small">Teléfono</label>
                                        <input name="Telefono" class="form-control input-telefono-padre" pattern="\+505[0-9]{8}" maxlength="12" placeholder="+50512345678">
                                    </div>  
                                    </div>
                       
                            <div class="mt-3 text-center">
                                <button type="button" class="btn btn-success btn-sm px-4" onclick="agregarPadreNuevo()">
                                    <i class="fas fa-plus"></i> Agregar Padre
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

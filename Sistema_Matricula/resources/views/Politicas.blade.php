@extends('adminlte::page')

@section('title', 'Políticas de Privacidad')

@section('content_header')
    <div class="alert alert shadow-sm" style="background-color: rgb(226, 136, 100); border: none; color: white;">
        <h1 class="m-0"><i class="fas fa-user-shield mr-2"></i> Políticas y Términos de Uso</h1>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary shadow">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Marco Legal y Privacidad del Sistema</h3>
            </div>
            
            <div class="card-body">
                <div id="accordion">
                    <div class="card card-light shadow-none border">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100 text-dark font-weight-bold" data-toggle="collapse" href="#collapseOne">
                                    1. Tratamiento de Datos Personales
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="collapse show" data-parent="#accordion">
                            <div class="card-body">
                                Toda la información recolectada (Nombres, IDs, Correos) se utiliza exclusivamente para la gestión de reportes y seguimiento de procesos. El sistema cumple con los estándares de protección de datos vigentes en <strong>Nicaragua</strong>.
                            </div>
                        </div>
                    </div>

                    <div class="card card-light shadow-none border">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100 text-dark font-weight-bold" data-toggle="collapse" href="#collapseTwo">
                                    2. Confidencialidad de la Información
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                Los detalles técnicos de infraestructura y seguridad registrados en el sistema tienen carácter <strong>estrictamente confidencial</strong>. El acceso no autorizado a estos datos será sancionado según el reglamento interno.
                            </div>
                        </div>
                    </div>

                    <div class="card card-light shadow-none border">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100 text-dark font-weight-bold" data-toggle="collapse" href="#collapseThree">
                                    3. Responsabilidad del Usuario
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                El usuario es responsable de mantener la seguridad de sus credenciales de acceso. Cualquier acción realizada bajo su cuenta será de su entera responsabilidad.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer text-muted">
                <small> Abril, 2026</small>
            </div>
        </div>
    </div>
</div>
@stop
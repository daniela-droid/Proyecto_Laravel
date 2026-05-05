@extends('adminlte::page')

@section('title', 'Descripción del Sistema')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .info-box-custom {
            border-left: 5px solid #3f6570ff;
            transition: transform 0.3s;
        }
        .info-box-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .icon-circle {
            background-color: #3f6570ff;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        .step-line {
            border-left: 2px dashed #3f6570ff;
            margin-left: 25px;
            padding-left: 20px;
            position: relative;
        }
    </style>
@stop

@section('content_header')
<div style="background-color: rgb(117, 196, 218); color: dark; padding: 15px 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h1 style="margin: 0; font-size: 1.8rem;"><i class="fas fa-info-circle mr-2"></i> Guía Informativa del Sistema</h1>
    <p class="mb-0 opacity-75">Conoce las funciones y el propósito de tu plataforma administrativa.</p>
</div>
@stop

@section('content')
<div class="container-fluid pb-5">
    
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body">
                    <h3>¿Qué hace este sistema?</h3>
                    <p class="text-muted" style="font-size: 1.1rem;">
                        Esta plataforma ha sido desarrollada como una herramienta integral para la gestión técnica y administrativa. 
                        Su objetivo principal es centralizar la información de los <strong>Reportes de Incidencias</strong>, 
                        el seguimiento de <strong>Cortes Evaluativos</strong> y la organización de <strong>Modalidades</strong>.
                    </p>
                </div>
            </div>
        </div>
       
    </div>

    <h4 class="mt-4 mb-3 text-secondary">Módulos del Sistema</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="card info-box-custom h-100">
                <div class="card-body">
                    <div class="icon-circle"><i class="fas fa-clipboard-list"></i></div>
                    <h5>Gestión de Reportes</h5>
                    <p class="text-sm text-muted">Permite crear, editar y categorizar incidencias en áreas como Sistema, Infraestructura o Personal.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card info-box-custom h-100">
                <div class="card-body">
                    <div class="icon-circle"><i class="fas fa-calendar-check"></i></div>
                    <h5>Cortes Evaluativos</h5>
                    <p class="text-sm text-muted">Control de periodos académicos o administrativos, permitiendo cierres de notas y revisiones periódicas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card info-box-custom h-100">
                <div class="card-body">
                    <div class="icon-circle"><i class="fas fa-shield-alt"></i></div>
                    <h5>Seguridad y Privacidad</h5>
                    <p class="text-sm text-muted">Protección de datos bajo protocolos estandarizados y gestión de roles para administradores.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title font-weight-bold">Flujo de Trabajo Operativo</h5>
                </div>
                <div class="card-body">
                    <div class="step-line mb-4">
                        <strong>1. Registro de Información:</strong> Se ingresan los datos en los formularios correspondientes (Matriculas,Estudiantes,Reportes,Cortes etc).
                    </div>
                    <div class="step-line mb-4">
                        <strong>2. Procesamiento:</strong> El sistema valida la información y la almacena de forma segura en la base de datos MariaDB.
                    </div>
                    <div class="step-line">
                        <strong>3. Consulta y Salida:</strong> Los datos se visualizan en tablas dinámicas con opciones de búsqueda y filtrado.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@section('js')
    <script>
        console.log("Guía cargada correctamente.");
    </script>
@stop
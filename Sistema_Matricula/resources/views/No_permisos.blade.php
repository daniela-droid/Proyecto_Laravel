@extends('adminlte::page')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 
    <!-- Estilos de DataTables Buttons -->

@stop

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header" style="background-color:red; height: 5px;"></div>
        
        <div class="card-body text-center"> <h1 class="warning">Estimado, no tiene acceso al formulario</h1>
            
            <img src="https://media.istockphoto.com/id/1142686395/es/vector/c%C3%B3digo-binario-en-tel%C3%B3n-de-fondo-verde-oscuro-acceso-denegado.jpg?s=612x612&w=0&k=20&c=Pik61do41nElVGbu2jZAAmZpKW4WboLDbKtxoNS97wo=" 
                 class="img-fluid rounded mx-auto d-block" 
                 style="max-width: 400px; margin-top: 20px;">
            
            <div class="mt-4">
                <a href="{{ url('/') }}" class="btn btn-primary">Volver al Inicio</a>
            </div>
        </div>
    </div>
</div>




@stop
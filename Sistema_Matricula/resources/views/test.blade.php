@extends('adminlte::page')

@section('title', 'Test')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <!-- Estilos de DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@stop

@section('content_header')
  <div style="background-color: #47b3d4ff; color: dark; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem;">Sistema de Matricula</h1>
</div>
@stop
@section('content')

<!--<img src="https://i.pinimg.com/474x/02/12/11/021211d463f03aa754131ff28f3641a6.jpg">-->

 <div class="content-wrapper">
    <div class="content">
      <div class="hero">
        <div class="hero-card">
          <!-- Aquí puedes usar tu logo -->
          
          <h1 class="text-primary mb-3">Bienvenido</h1>
          <p class="lead text-muted">

          </p>
          <div class="mt-4">
            <a href="login" class="btn btn-primary btn-lg">
              <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
            
            <a href="#" class="btn btn-outline-secondary btn-lg ml-2">
              <i class="fas fa-info-circle"></i> Más Información
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer text-center">
    <strong>&copy; 2025 Sistema de Matrículas</strong>
  </footer>

</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
@stop








@extends('adminlte::page')

@section('title', 'Usuarios')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <!-- Estilos de DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@stop


@section('content_header')
  <div style="background-color: #47b3d4ff; color: dark; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem;">Listado de Usuarios</h1>
</div>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <a href="{{ route ('usuarios.create') }}"class="btn btn-success mb-3">
<i class="fas fa-plus"></i>Nuevo Usuario
</a>

<table id="tabla-estudiantes" class="table table-bordered table-striped table-hover">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Gmail</th>
                        <th>Password</th>
                        <th>Rol</th>
                     
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->gmail}}</td>
                            <td>{{ $usuario->password}}</td>
                            <td>{{ $usuario->rol }}</td>
                           
                            <td>
    <a href="{{route('usuarios.show',$usuario->id)}}"
    class="btn btn-info btn-sm">
    <i class="fas fa-eye"></i>
    </a>

    <a href="{{ route('usuarios.edit',$usuario->id) }}"
    class="btn btn-warning btn-sm">
    <i class="fas fa-edit"></i>
    </a>

    <form action="{{route('usuarios.destroy',$usuario->id)  }}"
    method="POST" style="display:inline-block">
    @csrf
    @method('DELETE')
    <button type="submit"
    class="btn btn-danger btn-sm"
    onclik="return confirm('Seguro que quiere eliminar?')">
    <i class="fas fas-trash"></i>
    </button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

@endsection
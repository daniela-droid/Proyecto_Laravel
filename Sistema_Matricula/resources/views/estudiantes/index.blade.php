@extends('adminlte::page')

@section('title', 'Estudiantes')

@section('content_header')

    <!-- Panel superior -->
<div style="background-color: #47b3d4ff; color: dark; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem;">Listado de Estudiantes</h1>
</div>

@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('estudiantes.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nuevo Estudiante
            </a>

            <table id="tabla-estudiantes" class="table table-bordered table-striped table-hover">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Sexo</th>
                        <th>Cedula</th>
                        <th>Edad</th>
                        <th>Celular</th>
                        <th>Nombre Madre</th>
                        <th>Nombre Padre</th>
                        <th>Comarca</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estudiantes as $estudiante)
                        <tr>
                            <td>{{ $estudiante->id }}</td>
                            <td>{{ $estudiante->nombre }}</td>
                            <td>{{ $estudiante->apellido }}</td>
                            <td>{{ $estudiante->sexo }}</td>
                            <td>{{ $estudiante->cedula }}</td>
                            <td>{{ $estudiante->edad }}</td>
                            <td>{{ $estudiante->celular }}</td>
                            <td>{{ $estudiante->nombre_madre }}</td>
                            <td>{{ $estudiante->nombre_padre }}</td>
                            <td>{{ $estudiante->comarca }}</td>
                            <td>
                                <!-- Botón Ver -->
                                <a href="{{ route('estudiantes.show', $estudiante->id) }}" 
                                   class="btn btn-info btn-sm">
                                   <i class="fas fa-eye"></i>
                                </a>

                                <!-- Botón Editar -->
                                <a href="{{ route('estudiantes.edit', $estudiante->id) }}" 
                                   class="btn btn-warning btn-sm">
                                   <i class="fas fa-edit"></i>
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('estudiantes.destroy', $estudiante->id) }}" 
                                      method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar este estudiante?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop


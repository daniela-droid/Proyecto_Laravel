@extends('adminlte::page')

@section('title', 'Matriculas')

@section('content_header')
    <h1>Listado de Matriculas</h1>
@stop

@section('content')

<div class="card">
        <div class="card-body">
            <a href="{{ route('matriculas.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nuevo Matricula
            </a>

            <table id="tabla-matriculas" class="table table-bordered table-striped table-hover">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Id_Estudiantes</th>
                        <th>Id_Asignaturas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matriculas as $matricula)
                        <tr>
                            <td>{{ $matricula->id }}</td>
                            <td>{{ $matricula->id_estudiantes }}</td>
                            <td>{{ $matricula->id_asignaturas}}</td>
                          
                            <td>
                                <!-- Botón Ver -->
                                <a href="{{ route('matriculas.show', $matricula->id) }}" 
                                   class="btn btn-info btn-sm">
                                   <i class="fas fa-eye"></i>
                                </a>

                                <!-- Botón Editar -->
                                <a href="{{ route('matriculas.edit', $matricula->id) }}" 
                                   class="btn btn-warning btn-sm">
                                   <i class="fas fa-edit"></i>
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('matriculas.destroy', $matricula->id) }}" 
                                      method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar esta matricula?')">
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


@extends('adminlte::page')

@section('title', 'Notas')

@section('content_header')

 <h1>Listado de Notas</h1>
@stop

@section('content')

<div class="card">
        <div class="card-body">
            <a href="{{ route('notas.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nueva Nota
            </a>

            <table id="tabla-notas" class="table table-bordered table-striped table-hover">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Id_Estudiantes</th>
                        <th>Id_Asignaturas</th>
                        <th>Id_usuarios</th>
                        <th>Notas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notas as $nota)
                        <tr>
                            <td>{{ $nota->id }}</td>
                            <td>{{ $nota->id_estudiantes }}</td>
                            <td>{{ $nota->id_asignaturas}}</td>
                            <td>{{ $nota->id_usuarios}}</td>
                             <td>{{ $nota->notas}}</td>
                            <td>
                                <!-- Botón Ver -->
                                <a href="{{ route('notas.show', $nota->id) }}" 
                                   class="btn btn-info btn-sm">
                                   <i class="fas fa-eye"></i>
                                </a>

                                <!-- Botón Editar -->
                                <a href="{{ route('notas.edit', $nota->id) }}" 
                                   class="btn btn-warning btn-sm">
                                   <i class="fas fa-edit"></i>
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('notas.destroy', $nota->id) }}" 
                                      method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar estas notas?')">
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


@extends('adminlte::page')

@section('title', 'Asignaturas')

@section('content')
@section('content_header')

    <!-- Panel superior -->
<div style="background-color: #47b3d4ff; color: dark; padding: 10px 20px; border-radius: 5px;">
    <h1 style="margin: 0; font-size: 1.5rem;">Listado de Asignaturas</h1>
</div>

@stop

 <!-- Botón Editar -->
            <a href="{{ route('asignaturas.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nueva Asignatura
            </a>
        </div>
        <div class="card-body">
            <table id="tabla-asignaturas" class="table table-bordered table-striped table-hover">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($asignaturas as $asignatura)
                        <tr>
                            <td>{{ $asignatura->id }}</td>
                            <td>{{ $asignatura->nombre }}</td>
                            <td>
                                <!-- Boton  de ver -->
                                <a href="{{ route('asignaturas.show', $asignatura->id) }}" 
                                   class="btn btn-info btn-sm">
                                   <i class="fas fa-eye"></i>
                                </a>

                                <!-- Boton  de editar -->
                                <a href="{{ route('asignaturas.edit', $asignatura->id) }}" 
                                   class="btn btn-warning btn-sm">
                                   <i class="fas fa-edit"></i>
                                </a>

                                <!-- Boton de eliminar -->
                                <form action="{{ route('asignaturas.destroy', $asignatura->id) }}" 
                                      method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar esta asignatura?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No hay Asignaturas registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



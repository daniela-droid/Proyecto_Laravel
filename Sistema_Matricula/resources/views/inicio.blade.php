@extends('adminlte::page')

@section('title', 'Sistema de Matrícula')

@section('content_header')
<div style="
    background: linear-gradient(90deg, #1e293b 0%, #334155 100%);
    color: white;
    padding: 15px 25px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
">
    <h1 style="margin: 0; font-size: 1.4rem; font-weight: 600; letter-spacing: 0.5px;">
        <i class="fas fa-university mr-2"></i> Gestión Académica
    </h1>

    <div style="text-align: right;">
        <span style="display: block; font-size: 0.9rem; opacity: 0.9;">
            <i class="fas fa-user-circle"></i> {{ Auth::user()->Email }}
        </span>
        <form action="{{ route('logout') }}" method="POST" style="margin-top: 5px;">
            @csrf
            <button type="submit" class="btn btn-danger btn-xs" style="border-radius: 20px; padding: 2px 12px;">
                <i class="fas fa-power-off"></i> Cerrar sesión
            </button>
        </form>
    </div>
</div>


@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center mt-4 mb-3">
            <h4 style="color: #475569; font-weight: 300;">Panel General</h4>
            <div style="width: 50px; height: 3px; background: #3b82f6; margin: 10px auto; border-radius: 2px;"></div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div id="miniCarousel" class="carousel slide shadow-sm" data-ride="carousel" style="border-radius: 15px; overflow: hidden; border: 4px solid white;">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://images.unsplash.com/photo-1510074377623-8cf13fb86c08?auto=format&fit=crop&q=80&w=800" class="d-block w-100" alt="Soporte" style="height: 250px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGKc6OPNtTPllwI8FyySvHmsHvGLgmkB3hMQ&s" class="d-block w-100" alt="Gestión" style="height: 250px; object-fit: cover;">
                    </div>

                     <div class="carousel-item">
                        <img src="data:image/jpeg;base64,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" class="d-block w-100" alt="Gestión" style="height: 250px; object-fit: cover;">
                    </div>
                    
                </div>
                {{-- Controles para que no se vea estático --}}
                <a class="carousel-control-prev" href="#miniCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#miniCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-5 justify-content-center">
        @if(Auth::user()->rol === 'admin')
            @php
                // Aviso rápido para que el admin vea solicitudes pendientes desde el inicio.
                $solicitudesPendientes = \App\Models\SolicitudCorreccionNota::pendientes()->count();
            @endphp
            <div class="col-md-4">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-warning"><i class="fas fa-bell"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Solicitudes de corrección</span>
                        <span class="info-box-number">{{ $solicitudesPendientes }} pendientes</span>
                        <a href="{{ route('admin.solicitudes-notas.index') }}" class="btn btn-sm btn-outline-warning mt-1">Revisar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-primary"><i class="fas fa-users-cog"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Administradores</span>
                        <a href="{{ route('admins.index') }}" class="btn btn-sm btn-outline-info mt-1">Ver listado</a>
                    </div>
                </div>
            </div>
        @elseif(Auth::user()->rol === 'docentes')
            @php
                // Notificaciones sin leer del docente
                $notificacionesNoLeidas = Auth::user()->unreadNotifications()->where('type', 'App\\Notifications\\SolicitudCorreccionNotaResuelta')->get();
                $cantidadNoLeidas = $notificacionesNoLeidas->count();
            @endphp
            <div class="col-md-8">
                <div class="card shadow-sm" style="border-left: 5px solid #184c77;">
                    <div class="card-header" style="background: linear-gradient(90deg, #263a4d 0%, #8a5f2f 100%); color: white;">
                        <h5 class="m-0"><i class="fas fa-bell"></i> Notificaciones de Solicitudes de Corrección</h5>
                    </div>
                    <div class="card-body">
                        @if($cantidadNoLeidas > 0)
                            <div class="alert alert-info" role="alert">
                                Tienes <strong>{{ $cantidadNoLeidas }} notificación(es) sin leer</strong>
                            </div>
                            
                            @foreach($notificacionesNoLeidas as $notificacion)
                                @php
                                    $data = $notificacion->data;
                                    $estadoBadge = $data['accion'] === 'aprobada' ? 'badge-success' : 'badge-danger';
                                @endphp
                                <div class="alert alert-{{ $data['color'] }} alert-dismissible fade show" role="alert">
                                    <strong><i class="fas {{ $data['icono'] }}"></i> {{ $data['mensaje'] }}</strong>
                                    
                                    <div class="mt-2" style="font-size: 0.95rem;">
                                        @if($data['nota_sugerida'])
                                            <p><strong>Nota sugerida:</strong> {{ $data['nota_sugerida'] }}</p>
                                        @endif
                                        
                                        @if($data['respuesta_admin'])
                                            <p><strong>Comentario del admin:</strong></p>
                                            <p style="padding: 8px; background-color: rgba(0,0,0,0.05); border-left: 3px solid #999; margin: 5px 0;">
                                                {{ $data['respuesta_admin'] }}
                                            </p>
                                        @endif
                                        
                                        @if($data['accion'] === 'aprobada' && $data['aprobada_hasta'])
                                            <p class="mb-0"><strong>Válida hasta:</strong> {{ \Carbon\Carbon::parse($data['aprobada_hasta'])->format('d/m/Y H:i') }}</p>
                                        @endif
                                    </div>
                                    
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="marcarComoLeida('{{ $notificacion->id }}')">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-success" role="alert">
                             No tienes notificaciones pendientes
                            </div>
                        @endif

                        @php
                            // Mostrar también notificaciones ya leídas
                            $notificacionesLeidas = Auth::user()->readNotifications()->where('type', 'App\\Notifications\\SolicitudCorreccionNotaResuelta')->orderBy('read_at', 'desc')->limit(5)->get();
                        @endphp
                        
                        @if($notificacionesLeidas->count() > 0)
                            <div class="mt-3">
                                <h6 style="color: #666;">Historial reciente:</h6>
                                <div class="list-group list-group-sm">
                                    @foreach($notificacionesLeidas as $notificacion)
                                        @php
                                            $data = $notificacion->data;
                                        @endphp
                                        <div class="list-group-item" style="background-color: #f8f9fa; border-left: 3px solid {{ $data['accion'] === 'aprobada' ? '#28a745' : '#dc3545' }};">
                                            <small>
                                                <strong><i class="fas {{ $data['icono'] }}"></i> {{ $data['mensaje'] }}</strong>
                                                <br>
                                                <span style="color: #999;">{{ $notificacion->read_at->format('d/m/Y H:i') }}</span>
                                            </small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@stop

@section('css')
<style>
    /* Ajustes para que combine con el gris de AdminLTE */
    .content-wrapper {
        background-color: #f4f6f9 !important;
    }
    
    .carousel-item img {
        transition: transform 0.5s ease;
    }
</style>
@stop

@section('js')
<script>
    // Esto asegura que el carrusel se mueva solo cada 3 segundos
    $('.carousel').carousel({
        interval: 3000
    })

    // Función para marcar notificación como leída
    function marcarComoLeida(notificationId) {
        fetch(`/notificaciones/${notificationId}/marcar-leida`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                // La notificación se ha marcado como leída
                console.log('Notificación marcada como leída');
            }
        }).catch(error => console.error('Error:', error));
    }
</script>
@stop

<?php

namespace App\Notifications;

use App\Models\SolicitudCorreccionNota;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SolicitudCorreccionNotaResuelta extends Notification
{
    use Queueable;

    protected $solicitud;
    protected $accion;

    /**
     * Create a new notification instance.
     *
     * @param SolicitudCorreccionNota $solicitud
     * @param string $accion 'aprobada' o 'rechazada'
     */
    public function __construct(SolicitudCorreccionNota $solicitud, string $accion)
    {
        $this->solicitud = $solicitud;
        $this->accion = $accion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Almacenar en la base de datos
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $mensaje = $this->accion === 'aprobada'
            ? 'Tu solicitud de corrección de nota ha sido APROBADA'
            : 'Tu solicitud de corrección de nota ha sido RECHAZADA';

        $icono = $this->accion === 'aprobada' ? 'fa-check-circle' : 'fa-times-circle';
        $color = $this->accion === 'aprobada' ? 'success' : 'danger';

        return [
            'mensaje' => $mensaje,
            'accion' => $this->accion,
            'nota_id' => $this->solicitud->id_nota,
            'solicitud_id' => $this->solicitud->id,
            'respuesta_admin' => $this->solicitud->respuesta_admin,
            'nota_sugerida' => $this->solicitud->nota_sugerida,
            'aprobada_hasta' => $this->solicitud->aprobada_hasta,
            'icono' => $icono,
            'color' => $color,
            'timestamp' => now(),
        ];
    }
}

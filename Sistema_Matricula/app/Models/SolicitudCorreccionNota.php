<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCorreccionNota extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_correccion_notas';

    protected $fillable = [
        'id_nota',
        'id_docente',
        'id_admin',
        'estado',
        'motivo',
        'nota_sugerida',
        'respuesta_admin',
        'aprobada_hasta',
        'usada_at',
    ];

    protected $casts = [
        'nota_sugerida' => 'double',
        'aprobada_hasta' => 'datetime',
        'usada_at' => 'datetime',
    ];

    public function nota()
    {
        return $this->belongsTo(Notas::class, 'id_nota');
    }

    public function docente()
    {
        return $this->belongsTo(Docentes::class, 'id_docente');
    }

    public function admin()
    {
        return $this->belongsTo(Usuario::class, 'id_admin');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeAprobadasVigentes($query)
    {
        return $query->where('estado', 'aprobada')
            ->whereNull('usada_at')
            ->where(function ($q) {
                $q->whereNull('aprobada_hasta')
                    ->orWhere('aprobada_hasta', '>=', now());
            });
    }
}

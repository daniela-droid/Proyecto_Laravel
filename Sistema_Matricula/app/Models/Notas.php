<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class Notas extends Model
{
   /** @use HasFactory<\Database\Factories\NotasFactory> */
    use HasFactory;
    // use HashRouteKey;
    protected $table='notas';
            protected $fillable=[
                    'id_matricula',
                    'id_horario',
                    'id_corte_evaluativo',
                   'nota_normal',//es decimal5,2
                    'nota_especial',
                    'observacion', //por si algun estudainte esta pendiente
                     'id_usuario',
                     'promedio'

         ];


         protected $casts = [
        'nota_normal' => 'double',
        'nota_especial' => 'double',
        'promedio' => 'double',
    ];
    //relaciones
   public function matriculas()
    {
        return $this->belongsTo(Matriculas::class, 'id_matricula');
    }

    // Una matrícula pertenece a una asignatura
    public function horarios()
    {
        return $this->belongsTo(Horarios::class, 'id_horario');
    }
    public function cortes()
    {
        return $this->belongsTo(cortes_evaluativos::class, 'id_corte_evaluativo');
    }

    public function usuarios(){
        return $this->belongsTO(Usuario::class, 'id_usuario');
    }

    public function solicitudesCorreccion()
    {
        return $this->hasMany(SolicitudCorreccionNota::class, 'id_nota');
    }

    // Al borrar una nota, eliminar sus solicitudes de corrección relacionadas
    protected static function booted()
    {
        static::deleting(function ($nota) {
            try {
                $nota->solicitudesCorreccion()->delete();
            } catch (\Exception $e) {
                \Log::error('Error borrando solicitudes de corrección para nota ' . ($nota->id ?? '?:id') . ': ' . $e->getMessage());
            }
        });
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
    class Asignatura  extends Model
    {
        protected $table = 'asignaturas';
        /** @use HasFactory<\Database\Factories\AsignaturasFactory> */
        use HasFactory;
        /*hacemos uso de los timestames*/
    public $timestamps = true;
    //    use HashRouteKey; 
    protected $fillable=[
     
            'Nombre',
            'Descripcion',
            'Código',
            'tipo'


    ];
//como una relacion de uno a muchos
public function notas()
{
    return $this->hasMany(Notas::class, 'id_asignaturas');
}

public function matriculas()
    {
        return $this->hasMany(Matriculas::class, 'id_asignaturas');
    }

public function horarios()
    {
        return $this->hasMany(Horarios::class, 'id_asignatura');
    }

    protected static function booted()
    {
        static::deleting(function ($asignatura) {
            try {
                $asignatura->horarios->each(function ($horario) {
                    $horario->delete();
                });
            } catch (\Exception $e) {
                \Log::error('Error borrando horarios asociados a la asignatura ' . ($asignatura->id ?? '?:id') . ': ' . $e->getMessage());
            }
        });
    }

}

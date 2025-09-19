<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notas extends Model
{
   /** @use HasFactory<\Database\Factories\NotasFactory> */
    use HasFactory;
protected $table='notas';
        protected $fillable=[
                'id_estudiantes',
                'id_asignaturas',
                'id_usuarios',
                'notas'
        ];

    //relaciones
   public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiantes');
    }

    // Una matrícula pertenece a una asignatura
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'id_asignaturas');
    }
    public function usuarios(){
        return $this->belongsTO(Usuario::class, 'id_usuarios');
    }


}

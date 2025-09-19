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
        return $this->belongsTo(Estudiantes::class, 'id_estudiantes');
    }

    // Una matrícula pertenece a una asignatura
    public function asignatura()
    {
        return $this->belongsTo(Asignaturas::class, 'id_asignaturas');
    }
    public function usuarios(){
        return $this->belongsTO(Usuarios::class, 'id_usuarios');
    }


}

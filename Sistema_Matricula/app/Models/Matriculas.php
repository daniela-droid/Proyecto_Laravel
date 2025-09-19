<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matriculas extends Model
{

    protected $table = 'matriculas';
    /** @use HasFactory<\Database\Factories\MatriculasFactory> */
    use HasFactory;
    public $timestamps= true;

    protected $fillable=[

    'id_estudiantes',
    'id_asignaturas'

    ];


// Una matrícula pertenece a un estudiante
    public function estudiantes()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiantes');
    }

    // Una matrícula pertenece a una asignatura
    public function asignaturas()
    {
        return $this->belongsTo(Asignatura::class, 'id_asignaturas');
    }


}

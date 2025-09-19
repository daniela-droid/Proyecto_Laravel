<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
     protected $table = 'estudiantes'; 
    /** @use HasFactory<\Database\Factories\EstudiantesFactory> */
    use HasFactory;

public $timestamps=true;

    protected $fillable=[
    
            'nombre',
            'apellido',
            'sexo',
            'cedula',
            'edad',
            'celular',
            'nombre_madre',
            'nombre_padre',
            'comarca'
            

    ];

public function matriculas()
    {
        return $this->hasMany(Matriculas::class, 'id_estudiantes');
    }

    public function notas()
    {
        return $this->hasMany(Notas::class, 'id_estudiantes');
    }
}

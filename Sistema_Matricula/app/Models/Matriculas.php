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

    'Id_estudiantes',
    'Id_asignatura'

    ];

//define una relacion de uno a muchos
public function estudiante(){
    return $this->belongsTO(estudiante::class);
}

public function asignaturas(){
    return $this->belongsTo(asignaturas::class);
}

}

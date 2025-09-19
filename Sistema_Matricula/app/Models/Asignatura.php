<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Asignatura
     extends Model
    {
        protected $table = 'asignaturas';
        /** @use HasFactory<\Database\Factories\AsignaturasFactory> */
        use HasFactory;
        /*hacemos uso de los timestames*/
    public $timestamps = true;

    protected $fillable=[
    'nombre'


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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class Matriculas extends Model
{

    protected $table = 'matriculas';
    /** @use HasFactory<\Database\Factories\MatriculasFactory> */
    use HasFactory;
    //  use HashRouteKey;
    public $timestamps= true;

        protected $fillable=[
            'id_estudiante',
            'id_grupo',
            'id_periodo_academicos',
            'id_usuario',
            'fecha_matricula',//date
            'estado',  //enum
            'observaciones'//string

        ];


// Una matrícula pertenece a un estudiante
    public function estudiantes()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }


    public function grupos()
    {
        return $this->belongsTo(Grupos::class, 'id_grupo');
    }

     public function periodos()
    {
        return $this->belongsTo(Periodo_academicos::class, 'id_periodo_academicos');
    }

     public function usuarios()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
    ///////////////////////////////////////////

    public function notas()
    {
        return $this->hasMany(Notas::class, 'id_matricula');
    }





}

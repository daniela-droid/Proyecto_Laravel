<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Matriculas;
class Grupos extends Model
{
    protected $table='grupos';
    /** @use HasFactory<\Database\Factories\GruposFactory> */
    use HasFactory;
    public $timestamps=true;

    protected $fillable=[
                'Código',
                'Nombre',
                'Descripcion',
                'id_turno',
                'id_grado',
                'id_periodo_academicos'
                

    ];
//relaciones
    public function turnos()
    {
        return $this->belongsTo(Turnos::class, 'id_turno');
    }

    public function grados()
    {
    return $this->belongsTo(Grados::class, 'id_grado');
    }

    public function periodos(){

        return $this->belongsTo(Periodo_academicos::class, 'id_periodo_academicos');
    }
   
////////////////////////////////////////////////////////////////////////////////////////

    public function horarios()
        {
            return $this->hasMany(Horarios::class, 'id_grupo');
        }

    public function matriculas()
    {
        return $this->hasMany(Matriculas::class, 'id_grupo');
    }
      // Relación indirecta (opcional pero útil)
    public function estudiantes() {
        return $this->hasManyThrough(Estudiante::class, Matriculas::class, 'id_grupo', 'id', 'id', 'id_estudiante');
    }
}

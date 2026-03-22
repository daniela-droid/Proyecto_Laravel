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
                    'id_matricula',
                    'id_horario',
                    'id_corte_evaluativo',
                    'id_usuario',
                    'nota_normal',//es decimal5,2
                    'nota_especial',
                    'observacion' //por si algun estudainte esta pendiente
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


}

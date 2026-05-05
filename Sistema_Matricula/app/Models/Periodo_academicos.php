<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class Periodo_academicos extends Model
{
    protected $table='periodo_academicos';
    /** @use HasFactory<\Database\Factories\PeriodoAcademicoFactory> */
    use HasFactory;
    // use HashRouteKey;
     public $timestamps=true;

    protected $fillable=[
               'Nombre',
               'Fecha_inicio', //date
               'Fecha_fin',  //date
               'Activo'  //booleano 
                

    ];
        protected $casts = [
            'Activo' => 'boolean',
            'Fecha_inicio' => 'date',
            'Fecha_fin' => 'date',
        ];

    public function grupos(){
        return $this->hasMany(Grupos::class, 'id_periodo_academicos');
    }

      public function cortes(){
        return $this->hasMany(cortes_evaluativos::class, 'id_periodo_academicos');
    }

     public function matriculas(){
        return $this->hasMany(Matriculas::class, 'id_periodo_academicos');
    }
    
}

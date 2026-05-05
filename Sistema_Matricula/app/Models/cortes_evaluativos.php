<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class cortes_evaluativos extends Model
{
    protected $table='cortes_evaluativos';
    /** @use HasFactory<\Database\Factories\CortesEvaluativosFactory> */
    use HasFactory;
     public $timestamps=true;
    // use HashRouteKey;
    protected $fillable=[
        'id_modalidades',
        'nombre',
        'ponderacion',
        'id_periodo_academicos',
        'fecha_inicio',
        'fecha_fin'
     ];

   public function modalidades()
    {
        return $this->belongsTo(modalidades::class, 'id_modalidades');
    }

       public function periodos()
    {
        return $this->belongsTo(Periodo_academicos::class, 'id_periodo_academicos');
    }

    public function notas()
    {
        return $this->hasMany(Notas::class, 'id_corte_evaluativo');
    }

}

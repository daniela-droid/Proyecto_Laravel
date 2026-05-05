<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class aulas extends Model
{
    protected $table='aulas';
    /** @use HasFactory<\Database\Factories\AulasFactory> */
    use HasFactory;
    // use HashRouteKey;
    public $timestamps=true;
    protected $fillable=[
        'Nombre',
        'Capacidad'
  ];

 public function horarios()
    {
        return $this->hasMany(Horarios::class, 'id_aula');
    }


}

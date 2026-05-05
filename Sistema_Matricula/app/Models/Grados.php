<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class Grados extends Model
{
     protected $table='grados';
    /** @use HasFactory<\Database\Factories\GradosFactory> */
    
    // use HashRouteKey;
 use HasFactory;
    public $timestamps=true;

    protected $fillable=[
             'Nombre',
             'Nivel',
             'tipo_nivel'
                

    ];
    

public function grupos()
    {
        return $this->hasMany(Grupos::class, 'id_grado');
    }
}

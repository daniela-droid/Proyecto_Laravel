<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class modalidades extends Model
{
    protected $table='modalidades';
    /** @use HasFactory<\Database\Factories\ModalidadesFactory> */
    use HasFactory;
    // use HashRouteKey;
public $timestamps=true;

    protected $fillable=[
              'nombre',
              'codigo',
              'descripcion'
                

    ];

public function cortes()
    {
        return $this->hasMany(cortes_evaluativos::class, 'id_modalidades');
    }
    

}

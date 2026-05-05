<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class comarca extends Model
{
    protected $table='comarcas';
    /** @use HasFactory<\Database\Factories\ComarcaFactory> */
    use HasFactory;
    // use HashRouteKey;
    public $timestamps=true;

    protected $fillable=[

            'Comarca',
            'Direccion'

    ];


public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'id_comarca');
    }



}

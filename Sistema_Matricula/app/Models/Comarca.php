<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comarca extends Model
{
    protected $table='comarcas';
    /** @use HasFactory<\Database\Factories\ComarcaFactory> */
    use HasFactory;

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

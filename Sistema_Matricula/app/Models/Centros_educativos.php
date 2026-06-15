<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centros_educativos extends Model
{
    /** @use HasFactory<\Database\Factories\CentrosEducativosFactory> */
    use HasFactory;

    protected $table = 'centros_educativos';

    protected $fillable = [
        'codigo',
        'nombre',
        'departamento',
        'municipio',
        'direccion',
        'telefono',
        'correo',
        'director',
    ];

    public static function principal(): ?self
    {
        return self::query()->orderBy('id')->first();
    }
}

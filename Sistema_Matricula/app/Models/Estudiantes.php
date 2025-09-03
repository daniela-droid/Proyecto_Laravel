<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiantes extends Model
{
     protected $table = 'estudiantes'; 
    /** @use HasFactory<\Database\Factories\EstudiantesFactory> */
    use HasFactory;

public $timestamps=true;

    protected $fillable=[
    
            'nombre',
            'apellido',
            'sexo',
            'cedula',
            'edad',
            'celular',
            'nombre_madre',
            'nombre_padre',
            'comarca'
            

    ];



}

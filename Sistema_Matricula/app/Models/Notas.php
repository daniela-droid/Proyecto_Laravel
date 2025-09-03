<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notas extends Model
{
   /** @use HasFactory<\Database\Factories\NotasFactory> */
    use HasFactory;

        protected $fillable=[
        
                'Id_Estudiantes',
                'Id_Asignarura',
                'Id_usuario',
                'notas'
        ];

    //relaciones
    public function estudiantes(){
    return $this->belongsTO(estudiantes::class);
    }

    public function asignaturas(){
        return $this->belongsTO(asignaturas::class);
    }
    public function usuarios(){
        return $this->belongsTO(usuarios::class);
    }


}

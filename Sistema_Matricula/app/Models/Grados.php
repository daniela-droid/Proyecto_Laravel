<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grados extends Model
{
     protected $table='grados';
    /** @use HasFactory<\Database\Factories\GradosFactory> */
    use HasFactory;

 use HasFactory;
    public $timestamps=true;

    protected $fillable=[
             'Nombre',
             'Nivel'
                

    ];
    

public function grupos()
    {
        return $this->hasMany(Grupos::class, 'id_grado');
    }
}

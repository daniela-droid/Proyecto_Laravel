<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    protected $table='turnos';
   
    /** @use HasFactory<\Database\Factories\TurnosFactory> */
    use HasFactory;
    public $timestamps=true;

    protected $fillable=[
        'id',
        'Nombre',
        'Descripcion'

    ];

    //esto creo que es para decirle a grupos que tiene permiso de relacionarce conmigo

    public function grupos()
    {
        return $this->hasMany(Grupos::class, 'id_turnos');
    }
}

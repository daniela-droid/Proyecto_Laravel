<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    protected $table='grupos';
    /** @use HasFactory<\Database\Factories\GruposFactory> */
    use HasFactory;
    public $timestamps=true;

    protected $fillable=[
                'id',
                'Codigo',
                'Nombre',
                'Descripcion',
                'Seccion',
                'Grado',
                'id_turnos',
                'id_docentes',
                'Periodo'

    ];
//relaciones
    public function turnos()
    {
        return $this->belongsTo(Turnos::class, 'id_turnos');
    }

    public function docentes()
    {
    return $this->belongsTo(Docentes::class, 'id_docentes');
    }



}

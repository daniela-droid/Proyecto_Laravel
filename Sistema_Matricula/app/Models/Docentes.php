<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docentes extends Model
{
    protected $table= 'docentes';
    /** @use HasFactory<\Database\Factories\DocentesFactory> */
    use HasFactory;

public $timestamps=true;

    protected $fillable=[
                'id',
                'Nombre',
                'Apellido',
                'FechadeNacimiento',
                'Gmail',
                'Telefono',
                'Especialidad',
                'GrupoAsignado'

];
//esto creo que es para decirle a grupos que tiene permiso de relacionarce conmigo
public function grupos()
    {
        return $this->hasMany(Grupos::class, 'id_docentes');
    }
    
}

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
                'id_usuario',
                'Nombre',
                'Apellido',
                'FechadeNacimiento',
                'Email',
                'Telefono',
               'id_especialidads'

];

public function docente()
{
    // Un usuario pertenece a un registro de docente
    return $this->hasOne(Docentes::class, 'id_usuario');
}

public function usuarios()
    {
        // Relación con el modelo padres usando la llave 'id_padre'
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
public function especialidades()
    {
        // Relación con el modelo padres usando la llave 'id_padre'
        return $this->belongsTo(Especialidad::class, 'id_especialidads');
    }



//esto creo que es para decirle a grupos que tiene permiso de relacionarce conmigo
public function grupos()
    {
        return $this->hasMany(Grupos::class, 'id_docentes');
    }
    
public function horarios()
    {
        return $this->hasMany(Horarios::class, 'id_docente');
    }



}

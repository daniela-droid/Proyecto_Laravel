<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Estudiante extends Model
{
     protected $table = 'estudiantes'; 
    /** @use HasFactory<\Database\Factories\EstudiantesFactory> */
    use HasFactory;

public $timestamps=true;

    protected $fillable=[
            'Código_Persona',
            'Nombre',
            'Apellido',
            'Sexo',
            'Fecha_N',
            'Celular',
            'id_padre',
            'id_comarca'
            

    ];

    //metodo de la fecha
    public function getEdadAttribute()
    {
        // Si no hay fecha de nacimiento, devolvemos un guion o vacío
        if (!$this->Fecha_N) return '-';
        return Carbon::parse($this->attributes['Fecha_N'])->age;
    }

// --- RELACIONES HACIA ARRIBA que pertenencen a ---

    public function padre()
    {
        // Relación con el modelo padres usando la llave 'id_padre'
        return $this->belongsTo(Padres::class, 'id_padre');
    }

    public function comarca()
    {
        // Relación con el modelo comarca usando la llave 'id_comarca'
        return $this->belongsTo(Comarca::class, 'id_comarca');
    }

//////////////////////////////////////////////////////////////////////////////////

public function matriculas()
    {
        return $this->hasMany(Matriculas::class, 'id_estudiante');
    }

    public function notas()
    {
        return $this->hasMany(Notas::class, 'id_estudiantes');
    }









}

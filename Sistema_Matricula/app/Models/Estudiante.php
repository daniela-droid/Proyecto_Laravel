<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use \App\Traits\HashRouteKey;
class Estudiante extends Model
{
     protected $table = 'estudiantes'; 
    /** @use HasFactory<\Database\Factories\EstudiantesFactory> */
    use HasFactory;
    // use HashRouteKey;
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
     //funcion para saber si el padrre ha sido borrado de la bd
    public function padre()
    {
    return $this->belongsTo(Padres::class, 'id_padre')->withDefault([
        'Nombre_o_Tutor' => 'Sin asignar',
        'Apellido' => 'N/A'
    ]);
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
//para saber si ya esta matriculado algun estudiante 
    public function getEstaMatriculadoAttribute()
    {
        // Verifica si tiene al menos una matrícula (puedes filtrar por año si quieres)
        return $this->matriculas()->exists();
    }
    public function notas()
    {
        return $this->hasMany(Notas::class, 'id_estudiantes');
    }
   
    public function reportedoc()
    {
        return $this->hasMany(reportes_docente::class, 'id_estudiante');
    }









}

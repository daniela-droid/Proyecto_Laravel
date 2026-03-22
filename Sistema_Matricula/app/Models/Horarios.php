<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class horarios extends Model
{
    protected $table='horarios';
    /** @use HasFactory<\Database\Factories\HorariosFactory> */
    use HasFactory;

    public $timestamps=true;
    protected $fillable=[
        'id_grupo',
        'id_asignatura',
        'id_docente',
        'id_aula',
        'Dia_semana',
        'Hora_inicio',
        'Hora_fin'

    ];
    //COnversion para evitar conflucto con el time de laravel y el de mysql
public function setHoraInicioAttribute($value)
    {
        $this->attributes['Hora_inicio'] = Carbon::parse($value)->format('H:i:s');
    }

    public function setHoraFinAttribute($value)
    {
        $this->attributes['Hora_fin'] = Carbon::parse($value)->format('H:i:s');
    }

    //RELACIONES
      public function grupo()
    {// Relación con el modelo padres usando la llave 'id_padre'
        return $this->belongsTo(Grupos::class, 'id_grupo');
    }
      public function asignatura()
    {// Relación con el modelo padres usando la llave 'id_padre'
        return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }
      public function docente()
    {// Relación con el modelo padres usando la llave 'id_padre'
        return $this->belongsTo(Docentes::class, 'id_docente');
    }
      public function aula()
    {// Relación con el modelo padres usando la llave 'id_padre'
        return $this->belongsTo(Aulas::class, 'id_aula');
    }
//////////////////////////////////////////////////////////////////////////////

   public function notas()
    {
        return $this->hasMany(Notas::class, 'id_horario');
    }



}

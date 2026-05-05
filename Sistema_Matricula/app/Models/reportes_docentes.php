<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use \App\Traits\HashRouteKey;
class reportes_docentes extends Model
{
    protected $table="reportes_docentes";
    /** @use HasFactory<\Database\Factories\ReportesDocenteFactory> */
    use HasFactory;
//     use HashRouteKey;
        protected $fillable=[
                'id_docente',
                'id_estudiante',
                'titulo',
                'descripcion',
                'tipo'

        ];

        public function docentes()
        {
                // Relación con el modelo 
                return $this->belongsTo(Docentes::class, 'id_docente');
        }
        public function estudiantes()
        {
                // Relación con el modelo 
                return $this->belongsTo(Estudiante::class, 'id_estudiante');
        }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportes extends Model
{
    protected $table='reportes';
    /** @use HasFactory<\Database\Factories\ReportesFactory> */
    use HasFactory;
    public $timestamps=true;

     protected $fillable=[
        'id_docentes',
        'Descripcion'
            
            
    ];

//Relacion con docentes
public function docentes()
    {
        // Relación con el modelo padres usando la llave 'id_padre'
        return $this->belongsTo(Docentes::class, 'id_docentes');
    }




}

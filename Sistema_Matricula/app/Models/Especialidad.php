<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class especialidad extends Model
{
    protected $table='especialidads';
    /** @use HasFactory<\Database\Factories\EspecialidadFactory> */
    use HasFactory;
    // use HashRouteKey;
public $timestamps=true;

    protected $fillable=[
            
            'Especialidad',
            'Descripcion'
            
        
    ];

public function docentes()
    {
        return $this->hasMany(Docentes::class, 'id_especialidads');
    }




}

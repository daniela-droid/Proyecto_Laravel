<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class padres extends Model
{
    protected $table='padres';
    /** @use HasFactory<\Database\Factories\PadresFactory> */
    use HasFactory;

public $timestamps=true;

 protected $fillable=[
            'Nombre_o_Tutor',
            'Apellido',
            'Email',
            'Cedula',
            'Telefono'

    ];

public function estudiantes() {
    return $this->hasMany(Estudiante::class, 'id_padre');
}





}

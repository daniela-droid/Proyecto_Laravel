<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    protected $table='admins';
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory;
    public $timestamps=true;

    protected $fillable=[
            
        'id_usuarios',
        'Nombre',
        'Apellido',
        'Cargo'
            
        
    ];

     public function usuarios()
    {
        // Relación con el modelo padres usando la llave 'id_padre'
        return $this->belongsTo(Usuario::class, 'id_usuarios');
    }


}

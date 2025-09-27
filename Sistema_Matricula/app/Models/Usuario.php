<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Usuario extends Authenticatable//esto es para que laravel sepa que este es para login
{
     protected $table = 'usuarios';

         use HasFactory, Notifiable;
    /** @use HasFactory<\Database\Factories\UsuariosFactory> */
    use HasFactory;
    public $timestamps=true;

protected $fillable=[
    'nombre',
    'gmail',
    'password',
    'rol'

    ];


protected $hidden = ['password'];


public function notas()
    {
        return $this->hasMany(Notas::class, 'id_usuarios');
    }
}

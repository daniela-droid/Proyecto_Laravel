<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
     protected $table = 'usuarios';
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

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use \App\Traits\HashRouteKey;
class Usuario extends Authenticatable//esto es para que laravel sepa que este es para login
{
     protected $table = 'usuarios';

         use HasFactory, Notifiable;
    /** @use HasFactory<\Database\Factories\UsuariosFactory> */
    use HasFactory;
    // use HashRouteKey;
    public $timestamps=true;

            protected $fillable=[
                'Email',
                'password',
                'rol'

            ];

        //proteccion de contrasaenias
        protected $hidden = ['password'];

        protected function casts(): array
        {
            return [
                'email_verified_at' => 'datetime',
                'password' => 'hashed', // <--- Este es el "comando" que hashea todo automáticamente
            ];
        } 


//METODOS PARA RECORDARLE A ESTE MODELO LA RELACION QUE TIENE CON SU RESPECTIVO NOMBRE EN el metodo

     public function notas()
    {
        return $this->hasMany(Notas::class, 'id_usuario');
    }

        public function docentes()
    {
        return $this->hasOne(Docentes::class, 'id_usuario');
    }

   
     public function admin()
        {
            return $this->hasOne(Admin::class, 'id_usuarios','id');
        }
     public function matriculas()
    {
        return $this->hasMany(Matriculas::class, 'id_usuario');
    }

}

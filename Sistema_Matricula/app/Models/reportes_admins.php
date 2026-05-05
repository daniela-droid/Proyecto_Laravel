<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\HashRouteKey;
class reportes_admins extends Model
{
    protected $table="reportes_admins";
    /** @use HasFactory<\Database\Factories\ReportesAdminFactory> */
    use HasFactory;
    // use HashRouteKey;
    public $timestamps=true;

     protected $fillable=[
              'id_admin',
               'titulo',
               'descripcion',
               'categoria'
               

    ];

    public function admin()
    {
        // Relación con el modelo 
        return $this->belongsTo(Admin::class, 'id_admin');
    }



}

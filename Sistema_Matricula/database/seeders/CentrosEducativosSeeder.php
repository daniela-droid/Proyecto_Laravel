<?php

namespace Database\Seeders;

use App\Models\Centros_educativos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentrosEducativosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Centros_educativos::updateOrCreate(
            ['codigo' => 'CE-001'],
            [
                'nombre' => 'Nombre del Centro Educativo',
                'departamento' => 'Departamento',
                'municipio' => 'Municipio',
                'direccion' => 'Dirección del centro',
                'telefono' => null,
                'correo' => null,
                'director' => null,
            ]
        );
    }
}

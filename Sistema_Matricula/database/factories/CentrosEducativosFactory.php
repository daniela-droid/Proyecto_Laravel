<?php

namespace Database\Factories;

use App\Models\Centros_educativos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Centros_educativos>
 */
class CentrosEducativosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->bothify('CE-####'),
            'nombre' => 'Centro Educativo ' . $this->faker->lastName(),
            'departamento' => $this->faker->state(),
            'municipio' => $this->faker->city(),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'correo' => $this->faker->safeEmail(),
            'director' => $this->faker->name(),
        ];
    }
}

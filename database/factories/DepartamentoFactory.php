<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departamento>
 */
class DepartamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'CodDepartamento' => strtoupper($this->faker->unique()->lexify('???')), // 3 letras mayúsculas
            'DescDepartamento' => $this->faker->words(2, true), // "Recursos Humanos", "Finanzas"
            'FechaCreacionDepartamento' => now(),
            'VolumenDeNegocio' => $this->faker->randomFloat(2, 1000, 500000),
            'FechaBajaDepartamento' => null,
        ];
    }
}

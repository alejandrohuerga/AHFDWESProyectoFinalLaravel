<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Aquí devolveremos el array con los valores de los campos de Usuario.
        return [
            'nombre' => fake() -> nombre(), // Que me lo cree con un nombre inventado.
            'correo' => fake() -> correo(), // Que me lo cree con un correo inventado.
            'password' => static::$password ??= Hash::make('password'),
            'fecha_verificacion_correo' => now()
        ];
    }
}

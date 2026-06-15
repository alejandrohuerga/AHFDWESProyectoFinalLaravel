<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Instanciamos un objeto Usuario.
        $usuario= new Usuario();

        /**
         * Lo siguiente sera comprobar los atributos de Usuario en la migración.
         * Rellenamos dichos campos con los datos del usuario.
        */

        Usuario::insert([
            [
                'nombre' => 'Administrador',
                'correo' => env('ADMIN_EMAIL', 'admin@example.com'),
                'password' => Hash::make(env('ADMIN_PASSWORD', Str::random(32)))
            ],
            [
                'nombre' => 'Administrador2',
                'correo' => env('ADMIN2_EMAIL', 'admin2@example.com'),
                'password' => Hash::make(env('ADMIN2_PASSWORD', Str::random(32)))
            ]
        ]);
    }
}

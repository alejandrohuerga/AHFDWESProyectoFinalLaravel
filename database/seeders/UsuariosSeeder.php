<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'correo' => 'alejandrohuerga.dev@gmail.com',
                'password' => Hash::make('paso1234')
            ],
            [
                'nombre' => 'Administrador2',
                'correo' => 'whoishuergale@gmail.com',
                'password' => Hash::make('paso1234')
            ]
        ]);
    }
}

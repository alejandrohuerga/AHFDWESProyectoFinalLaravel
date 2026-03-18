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
        $usuario -> nombre ='Administrador';
        $usuario -> correo = 'alejandrohuerga.dev@gmail.com';
        $usuario -> password =Hash::make('Huerga2002');

        // Por último tendriamos que guardar el modelo usuario.
        $usuario -> save();
    }
}

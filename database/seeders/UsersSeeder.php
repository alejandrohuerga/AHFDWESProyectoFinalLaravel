<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creación de un usuario.
        $user = new User(); // Instacionamos el modelo User.

        // Nos fijamos en el modelo para ver que atributos son obligatorios para crear un Usuario.
        $user->name = 'John Doe';
        $user->email = 'admin@example.com';

        // Laravel se encargará de hashear la contraseña gracias al cast definido en el modelo User.
        // Sino tenemos el cast lo podemos hashear manualmente usando Hash::make('password').
        $user->password = 'paso';
        $user->save(); // Guardamos el usuario en la base de datos.

        /**
         * Por último debemos ejecutar la migración para que se ejecute el seeder y se cree el usuario en la base de datos.
         * 
         * Para eso ejecutamos el siguiente comando en la terminal:
         * php artisan db:seed --class=UsersSeeder (Seeder especifico)
         * 
         * Si queremos ejecutar todos los seeders registrados en DatabaseSeeder, podemos usar el comando:
         * php artisan db:seed (Todos los seeders registrados en DatabaseSeeder)
        */
    }
}

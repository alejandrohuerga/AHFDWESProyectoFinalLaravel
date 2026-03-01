<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Llamamos al seeder de usuarios para que se ejecute y cree el usuario en la base de datos.
         * Si tuviéramos más seeders, los llamaríamos aquí también para que se ejecuten todos juntos. Por ejemplo:
         * $this->call(PostsSeeder::class);
        */
        
        /**
         * Podemos aqui utilizar los factorys para crear varios usuarios de ejemplo, 
         * pero en este caso vamos a crear un usuario específico con datos concretos para asegurarnos de que existe un usuario con ID 1 en la base de datos,
         * ya que el seeder de comentarios depende de ese usuario para asignar el comentario a ese usuario.
         * User::factory(10)->create(); 
        */
        
        $this->call([
            /** 
             * Agregamos el seeder de comentarios para que se ejecute después del seeder de usuarios, 
             *ya que el seeder de comentarios depende de que exista un usuario con ID 1 para asignar el comentario a ese usuario.
            */
            UsersSeeder::class,
            CommentSeeder::class
        ]);
    }
}

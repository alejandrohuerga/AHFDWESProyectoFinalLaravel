<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Instanciamos el modelo Comment y creamos un nuevo comentario con datos de ejemplo.
        $comment = new Comment();
        //Nos fijamos en los atributos de la migración de comments para ver que atributos son obligatorios para crear un comentario.
        $comment ->user_id = 1; // Asignamos el ID del usuario al que pertenece el comentario. En este caso, el usuario con ID 1.
        $comment ->text = 'Este es un comentario de ejemplo.'; // Asignamos el contenido del comentario.
        $comment ->save(); // Guardamos el comentario en la base de datos.
    }
}

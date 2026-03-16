<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Clase con la migración de la clase demos.
 * Esta migración incluye la funcion up() la cual sirve para crear la base de datos.
 * También incluye la función down() en caso de hacer rollback poder borrar.
 * 
 * @author Alejandro De la Huerga Fernández
 * @since 16/03/2026
 * @version 1.0.0 última actualizacion 16/03/2026.
 */

return new class extends Migration
{

    
    /**
     * Run the migrations.
     * Hace que la migración se ejecute creando la tabla en la base de datos.
     */
    
    public function up(): void
    {
        Schema::create('demos' ,function (Blueprint $table){
            // Poniendo id Laravel nos creara una columna BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table -> id();
            $table -> bigInteger('usuario_id');
            $table -> foreign('usuario_id')-> references('id') -> on ('usuarios')->onDelete('cascade')->unsigned()->index();
            $table -> string('nombre_archivo');
            $table -> string('nombre_original');
            $table -> string('ruta');
            $table -> string('estado');
            $table -> timestamp('fecha_subida');
            $table -> timestamp('fecha_creacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Clase con la migración de la clase analisis.
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
        // Creación de la tbla en la base de datos analisis.
        Schema::create('analisis' ,function (Blueprint $table){
            // Poniendo id Laravel nos creara una columna BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table -> id();
            $table -> bigInteger('demo_id');
            $table -> foreign('demo_id')->references('id') ->on('demos')->onDelete('cascade')->unsigned()->index();
            $table -> json('resultado_json');
            $table -> string('nombre_mapa');
            $table -> integer('rondas_jugadas');
            $table -> integer ('puntuacion_equipo1');
            $table -> integer('puntuacion_equipo2');
            $table -> timestamp('fecha_analisis');
        });
    }

    /**
     * Reverse the migrations.
     * Función la cual realiza n rollback y vuelve atras las migraciones antes de ejecutar el up.
     */
    public function down(): void
    {
        // Borra la tabla análisis
        Schema::dropIfExists('analisis');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración la cual crea una tabla en la base de datos que almacena los archivos JSON,
 * con los resultados de los analisis de los archivos .dem previamente subidos por el usuario.
 * 
 * @author Alejandro De la Huerga.
 * @since 29/04/2026
 */

return new class extends Migration
{
    /**
     * Activa y ejecuta la migración creando la tabla con
     * los campos del métdo up().
     */
    public function up()
    {
        Schema::create('analises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('usuarios') 
                ->onDelete('cascade');
            $table->string('map_name');
            $table->json('stats');
            $table->timestamps();
        });
    }

    /**
     * RElimina la tabla de la base de datos ejecutando el método
     * down(), en caso que queramos revertir la situación.
     */
    public function down(): void
    {
        Schema::dropIfExists('analises');
    }
};

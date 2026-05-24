<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\BlueprintState;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        // Asi le decimos a Eloquent que cree la tabla jugadores en la base de datos.
        Schema::create('jugadores',function (Blueprint $table){
            $table -> id();
            $table -> string('nombreJugador');
            $table-> string('nombreEquipo');
            $table -> integer('bajas_totales');
            $table -> float('headshot_porcentaje'); // Porcentaje de tiro a la cabeza.
            $table -> integer('muertes_totales');
            $table -> float('KD_ratio');
            $table -> float('damage_por_ronda'); // Daño producido por ronda (media).
            $table -> integer('mapas_jugados');
            $table -> float('bajas_por_ronda');
            $table -> float('asistencias_por_ronda');
            $table -> float('muertes_por_ronda');
            $table -> float('rating_de_impacto'); // Impacto por ronda.
            // Nos indica cuando se ha creado el registro y cuando se ha modificado.
            $table ->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Borra la tabla demos de la base de datos (Revierte la función up)
        Schema::dropIfExists('jugadores');
    }
};

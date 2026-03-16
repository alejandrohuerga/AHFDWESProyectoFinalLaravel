<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analisis' ,function (Blueprint $table){
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
     */
    public function down(): void
    {
        //
    }
};

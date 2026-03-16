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
        Schema::create('demos' ,function (Blueprint $table){
            // Poniendo id Laravel nos creara una columna BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table -> id();
            $table -> bigInteger('usuario_id');
            $table -> foreign('usuario_id')-> references('id') -> on ('users')->onDelete('cascade')->unsigned()->index();
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

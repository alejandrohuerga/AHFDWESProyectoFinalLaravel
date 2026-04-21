<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
    {
        public function up(): void
    {
        Schema::table('demos', function (Blueprint $table) {
            // Creamos la columna 'datos_json' de tipo JSON para guardar los resultados del script de Node
            $table->json('datos_json')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::table('demos', function (Blueprint $table) {
            // Si nos arrepentimos, este comando borra la columna
            $table->dropColumn('datos_json');
        });
    }
};

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
        Schema::create('_t02_departamento', function (Blueprint $table) {
            $table->string('CodDepartamento') -> primary();
            $table->string('DescDepartamento');
            $table -> dateTime('FechaCreacionDepartamento');
            $table -> float('VolumenDeNegocio');
            $table -> dateTime('FechaBajaDepartamento') -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_t02_departamento');
    }
};

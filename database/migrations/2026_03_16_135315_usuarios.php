<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Clase con la migración de la clase usuarios.
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
        Schema::create('usuarios' ,function (Blueprint $table){
            $table -> id();
            $table -> string('nombre');
            $table -> string('correo');
            $table -> string('password');
            $table -> timestamp('fecha_verificacion_correo');
            $table -> timestamp('fecha_creacion_cuenta');
            $table -> timestamp('fecha_actualizacion');
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

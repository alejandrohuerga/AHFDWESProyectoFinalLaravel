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
        // Crea la tabla de la Base de Datos de usuarios.
        Schema::create('usuarios' ,function (Blueprint $table){
            // Poniendo id, Laravel nos creara una columna BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table -> id();
            $table -> string('nombre') -> unique();
            $table -> string('correo');
            $table -> string('password');
            $table -> timestamp('fecha_verificacion_correo') ->nullable(); // Así no falla si no se rellena.
            $table->rememberToken(); // Para realizar la función de "Recuerdame"
            $table->timestamps(); // Esto crea created_at y updated_at automáticamente.
        });

        // Crea la tabla de la base de datos password_reset_tokens.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Crea la tabla de la base de datos de sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }



    /**
     * Reverse the migrations.
     * Función la cual realiza n rollback y vuelve atras las migraciones antes de ejecutar el up.
     */

    public function down(): void
    {
        // Borra la tabla usuarios.
        Schema::dropIfExists('usuarios');
        // Borra la tabla password_reset_tokens
        Schema::dropIfExists('password_reset_tokens');
        // Borra la tbla sesiones.
        Schema::dropIfExists('sessions');
    }
};

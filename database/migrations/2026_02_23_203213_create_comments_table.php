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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Creamos un atributo llamado user_id
            $table->unsignedBigInteger('user_id');
            // Le indicamos que es una clave foránea que referencia al id de la tabla users y que se borre en cascada.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

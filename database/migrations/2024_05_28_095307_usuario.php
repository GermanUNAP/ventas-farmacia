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
        // Deshabilitar restricciones de claves foráneas
        Schema::disableForeignKeyConstraints();

        // Eliminar la tabla si existe
        Schema::dropIfExists('usuario');

        // Crear la tabla
        Schema::create('usuario', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('DNI');
            $table->string('role');
            $table->timestamps();
            $table->index('DNI');
        });

        // Habilitar restricciones de claves foráneas
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('usuario');
        Schema::enableForeignKeyConstraints();
    }
};

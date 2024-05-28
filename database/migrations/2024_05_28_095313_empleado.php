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
        Schema::dropIfExists('empleado');
        
        // Crear la tabla
        Schema::create('empleado', function (Blueprint $table) {
            $table->integer('DNI');
            $table->primary('DNI');
            $table->foreign('DNI')->references('DNI')->on('usuario')->onUpdate('cascade')->onDelete('cascade');    
            $table->timestamp('fecha_contratacion')->nullable();
            $table->integer('total_venta');
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
        Schema::dropIfExists('empleado');
        Schema::enableForeignKeyConstraints();
    }
};

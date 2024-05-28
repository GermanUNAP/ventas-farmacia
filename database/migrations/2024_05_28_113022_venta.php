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
        Schema::disableForeignKeyConstraints();
        
        // Eliminar la tabla si ya existe
        Schema::dropIfExists('venta');

        // Crear la tabla
        Schema::create('venta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('DNI_cliente')->nullable();
            $table->integer('FK_DNI_empleado')->nullable();
            $table->foreign('FK_DNI_empleado')->references('DNI')->on('empleado')->onUpdate('cascade')->onDelete('set null');
            $table->string('FK_ID_medicamento')->nullable(); // Permitir NULL
            $table->foreign('FK_ID_medicamento')->references('id')->on('medicamento')->onUpdate('cascade')->onDelete('set null');
            $table->string('nombre_cliente')->nullable();
            $table->string('medicamento_nombre');
            $table->integer('cantidad');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('venta');
        Schema::enableForeignKeyConstraints();
    }
};

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
        Schema::dropIfExists('detalleVentaMedicamento');
        Schema::create('detalleVentaMedicamento', function (Blueprint $table) {
            $table->id();
            $table->string('id_venta');
            $table->integer('id_medicamento')->unique()->nullable();
            $table->string('cantidad')->unique()->nullable();
            $table->decimal('precio_unidad', 10,2);
            $table->decimal('precio_total', 10, 2);
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

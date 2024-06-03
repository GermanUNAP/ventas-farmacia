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
        Schema::dropIfExists('venta');
        Schema::create('venta', function (Blueprint $table) {
            $table->id();
            $table->string('id_usuario');
            $table->string('dni_compraod')->nullable();
            $table->string('nombre_comprador')->nullable();
            $table->decimal('precio_pagar', 10,2);
            $table->datetime('fecha');
            $table->string('puntos-extra');
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

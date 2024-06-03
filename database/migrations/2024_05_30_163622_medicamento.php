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
        Schema::dropIfExists('medicamento');
        Schema::create('medicamento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('cantidad')->unique()->nullable();
            $table->string('precio_unidad_vender')->unique()->nullable();
            $table->decimal('precio_venta', 10,2);
            $table->decimal('precio_comprado', 10, 2);
            $table->datetime('vencimiento')->nullable();
            $table->string('lote');
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

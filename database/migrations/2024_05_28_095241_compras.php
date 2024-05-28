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
        Schema::create('compras', function (Blueprint $table){
            $table->id();
            $table->integer('proveedor_RUC');
            $table->string('proveedor_nombre');
            $table->string('medicamento_id');
            $table->string('medicamento_nombre');
            $table->integer('cantidad');
            $table->decimal('precio');
            $table->datetime('fecha');
            $table->datetime('fecha_vencimiento');
            $table->index('medicamento_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};

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
        Schema::dropIfExists('compra');
        Schema::create('compra', function (Blueprint $table) {
            $table->id();
            $table->string('ruc_proveedor');
            $table->string('nombre_proveedor')->unique()->nullable();
            $table->decimal('precio', 10, 2);
            $table->timestamp('fecha')->nullable();
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

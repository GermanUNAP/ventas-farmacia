<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class MedicamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('medicamento')->insert([
            'nombre' => Str::random(50),
            'cantidad' => rand(1, 100), // Suponiendo que la cantidad es un número entero
            'precio_unidad_vender' => rand(1, 100), // Suponiendo que es un precio, también puede ser decimal
            'precio_venta' => round(rand(1000, 100000) / 100, 2), // Genera un precio decimal aleatorio
            'precio_comprado' => round(rand(1000, 100000) / 100, 2), // Genera un precio decimal aleatorio
            'vencimiento' => now()->addDays(rand(1, 365)), // Fecha de vencimiento aleatoria dentro de un año
            'lote' => Str::random(10),
        ]);
    }
}

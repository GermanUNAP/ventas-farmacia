<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicamento;

class MedicamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medicamentos = [
            [
                'nombre' => 'Paracetamol',
                'cantidad' => 100,
                'precio_unidad_vender' => 0.50,
                'precio_venta' => 1.00,
                'precio_comprado' => 0.30,
                'vencimiento' => '2025-12-31 00:00:00',
                'lote' => 'L123456'
            ],
            [
                'nombre' => 'Ibuprofeno',
                'cantidad' => 200,
                'precio_unidad_vender' => 0.70,
                'precio_venta' => 1.50,
                'precio_comprado' => 0.40,
                'vencimiento' => '2025-11-30 00:00:00',
                'lote' => 'L789012'
            ],
            [
                'nombre' => 'Aspirina',
                'cantidad' => 150,
                'precio_unidad_vender' => 0.60,
                'precio_venta' => 1.20,
                'precio_comprado' => 0.35,
                'vencimiento' => '2025-10-31 00:00:00',
                'lote' => 'L345678'
            ],
            [
                'nombre' => 'Amoxicilina',
                'cantidad' => 120,
                'precio_unidad_vender' => 1.00,
                'precio_venta' => 2.00,
                'precio_comprado' => 0.80,
                'vencimiento' => '2024-08-30 00:00:00',
                'lote' => 'L234567'
            ],
            [
                'nombre' => 'Azitromicina',
                'cantidad' => 130,
                'precio_unidad_vender' => 1.50,
                'precio_venta' => 3.00,
                'precio_comprado' => 1.20,
                'vencimiento' => '2024-09-30 00:00:00',
                'lote' => 'L345679'
            ],
            [
                'nombre' => 'Metformina',
                'cantidad' => 140,
                'precio_unidad_vender' => 0.80,
                'precio_venta' => 1.60,
                'precio_comprado' => 0.60,
                'vencimiento' => '2025-07-30 00:00:00',
                'lote' => 'L456789'
            ],
            [
                'nombre' => 'Omeprazol',
                'cantidad' => 110,
                'precio_unidad_vender' => 0.90,
                'precio_venta' => 1.80,
                'precio_comprado' => 0.70,
                'vencimiento' => '2025-06-30 00:00:00',
                'lote' => 'L567890'
            ],
            [
                'nombre' => 'Clonazepam',
                'cantidad' => 160,
                'precio_unidad_vender' => 1.20,
                'precio_venta' => 2.40,
                'precio_comprado' => 1.00,
                'vencimiento' => '2025-05-30 00:00:00',
                'lote' => 'L678901'
            ],
            [
                'nombre' => 'Diazepam',
                'cantidad' => 170,
                'precio_unidad_vender' => 0.75,
                'precio_venta' => 1.50,
                'precio_comprado' => 0.50,
                'vencimiento' => '2025-04-30 00:00:00',
                'lote' => 'L789012'
            ],
            [
                'nombre' => 'Loratadina',
                'cantidad' => 180,
                'precio_unidad_vender' => 0.40,
                'precio_venta' => 0.80,
                'precio_comprado' => 0.30,
                'vencimiento' => '2025-03-30 00:00:00',
                'lote' => 'L890123'
            ],
            [
                'nombre' => 'Ciprofloxacino',
                'cantidad' => 190,
                'precio_unidad_vender' => 1.30,
                'precio_venta' => 2.60,
                'precio_comprado' => 1.10,
                'vencimiento' => '2025-02-28 00:00:00',
                'lote' => 'L901234'
            ],
            [
                'nombre' => 'Ketorolaco',
                'cantidad' => 100,
                'precio_unidad_vender' => 0.55,
                'precio_venta' => 1.10,
                'precio_comprado' => 0.45,
                'vencimiento' => '2025-01-31 00:00:00',
                'lote' => 'L012345'
            ],
            [
                'nombre' => 'Enalapril',
                'cantidad' => 150,
                'precio_unidad_vender' => 0.85,
                'precio_venta' => 1.70,
                'precio_comprado' => 0.65,
                'vencimiento' => '2024-12-31 00:00:00',
                'lote' => 'L123457'
            ],
            [
                'nombre' => 'Losartan',
                'cantidad' => 200,
                'precio_unidad_vender' => 0.95,
                'precio_venta' => 1.90,
                'precio_comprado' => 0.75,
                'vencimiento' => '2024-11-30 00:00:00',
                'lote' => 'L234568'
            ],
            [
                'nombre' => 'Levotiroxina',
                'cantidad' => 130,
                'precio_unidad_vender' => 0.65,
                'precio_venta' => 1.30,
                'precio_comprado' => 0.50,
                'vencimiento' => '2024-10-31 00:00:00',
                'lote' => 'L345689'
            ],
            [
                'nombre' => 'Prednisona',
                'cantidad' => 140,
                'precio_unidad_vender' => 0.70,
                'precio_venta' => 1.40,
                'precio_comprado' => 0.55,
                'vencimiento' => '2024-09-30 00:00:00',
                'lote' => 'L456790'
            ],
            [
                'nombre' => 'Atorvastatina',
                'cantidad' => 120,
                'precio_unidad_vender' => 0.60,
                'precio_venta' => 1.20,
                'precio_comprado' => 0.45,
                'vencimiento' => '2024-08-30 00:00:00',
                'lote' => 'L567801'
            ],
            [
                'nombre' => 'Metronidazol',
                'cantidad' => 110,
                'precio_unidad_vender' => 0.50,
                'precio_venta' => 1.00,
                'precio_comprado' => 0.40,
                'vencimiento' => '2024-07-31 00:00:00',
                'lote' => 'L678912'
            ],
            [
                'nombre' => 'Clindamicina',
                'cantidad' => 100,
                'precio_unidad_vender' => 1.10,
                'precio_venta' => 2.20,
                'precio_comprado' => 0.90,
                'vencimiento' => '2024-06-30 00:00:00',
                'lote' => 'L789023'
            ],
            [
                'nombre' => 'Simvastatina',
                'cantidad' => 90,
                'precio_unidad_vender' => 0.55,
                'precio_venta' => 1.10,
                'precio_comprado' => 0.45,
                'vencimiento' => '2024-05-31 00:00:00',
                'lote' => 'L890134'
            ]
        ];

        foreach ($medicamentos as $medicamento) {
            Medicamento::create($medicamento);
        }
    }
}

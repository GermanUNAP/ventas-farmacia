<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Medicamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VentaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        $medicamentos = Medicamento::all();
        
        if ($medicamentos->count() === 0) {
            $this->command->error('No hay medicamentos disponibles. Asegúrate de tener medicamentos antes de ejecutar este seeder.');
            return;
        }

        // Generar entre 1000 y 2000 ventas aleatorias
        $ventasCount = rand(1000, 2000);

        for ($i = 0; $i < $ventasCount; $i++) {
            DB::transaction(function () use ($faker, $medicamentos) {
                // Crear la venta
                $venta = Venta::create([
                    'id_usuario' => 1, // Cambia esto según sea necesario
                    'dni_comprador' => null,
                    'nombre_comprador' => null,
                    'precio_pagar' => 0, // Será actualizado después de crear los detalles
                    'fecha' => Carbon::now()->subDays(rand(0, 365)),
                    'puntos_extra' => 0 // Será calculado después
                ]);

                $totalVenta = 0;
                $minimoVenta = 200; // Mínimo total de la venta

                // Generar medicamentos hasta alcanzar el mínimo total
                while ($totalVenta < $minimoVenta) {
                    // Generar entre 1 y 5 medicamentos por venta
                    $medicamentosPorVenta = rand(1, 5);

                    for ($j = 0; $j < $medicamentosPorVenta; $j++) {
                        $medicamento = $medicamentos->random();
                        $cantidad = rand(1, 5);
                        $precioUnidad = $medicamento->precio_unidad_vender;
                        $precioTotal = $cantidad * $precioUnidad;

                        DetalleVenta::create([
                            'id_venta' => $venta->id,
                            'id_medicamento' => $medicamento->id,
                            'cantidad' => $cantidad,
                            'precio_unidad' => $precioUnidad,
                            'precio_total' => $precioTotal
                        ]);

                        // Reducir la cantidad en el stock
                        $medicamento->cantidad -= $cantidad;
                        $medicamento->save();

                        $totalVenta += $precioTotal;
                    }

                    // Si el total es menor que el mínimo, ajustar la cantidad
                    if ($totalVenta < $minimoVenta) {
                        // Restablecer el total y volver a calcular
                        $totalVenta = 0;
                        DetalleVenta::where('id_venta', $venta->id)->delete(); // Limpiar detalles anteriores
                    }
                }

                // Actualizar el precio total de la venta
                $venta->precio_pagar = $totalVenta;
                $venta->puntos_extra = $this->calcularPuntos($totalVenta);
                $venta->save();
            });
        }

        $this->command->info("$ventasCount ventas creadas con éxito.");
    }


    private function calcularPuntos($total)
    {
        // Define tu lógica para calcular los puntos
        return floor($total / 10); // Ejemplo: 1 punto por cada 10 unidades de precio total
    }
}

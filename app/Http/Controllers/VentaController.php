<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta; // Asegúrate de importar el modelo de Venta si lo tienes definido

class VentaController extends Controller
{
    public function realizarVenta(Request $request){
        try {
            // Validación de los datos recibidos
            $request->validate([
                'dni' => 'required|string|max:255',
                'medicamentos' => 'required|array',
                'medicamentos.*.id' => 'required|integer',
                'medicamentos.*.cantidad' => 'required|integer|min:1',
                'medicamentos.*.precio_unidad_vender' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
            ]);

            // Guardar la venta en la base de datos
            $venta = new Venta();
            $venta->dni_comprador = $request->dni;
            $venta->total = $request->total;
            $venta->save();

            // Guardar los detalles de los medicamentos vendidos
            foreach ($request->medicamentos as $medicamento) {
                $venta->medicamentos()->attach($medicamento['id'], [
                    'cantidad' => $medicamento['cantidad'],
                    'precio_unidad_vender' => $medicamento['precio_unidad_vender']
                ]);
            }

            // Devolver una respuesta de éxito
            return response()->json(['message' => 'Venta realizada con éxito'], 200);
        } catch (\Exception $e) {
            // Capturar y loguear el error
            \Log::error('Error al realizar venta: ' . $e->getMessage());

            // Devolver un mensaje de error genérico
            return response()->json(['message' => 'Error al realizar la venta. Por favor, intenta de nuevo más tarde.'], 500);
        }
    }

}

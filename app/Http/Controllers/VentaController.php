<?php

namespace App\Http\Controllers;

use App\Models\venta;
use Illuminate\Http\Request;
use App\Models\DetalleVenta;
use App\Models\Medicamento;
use App\Models\Cliente;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(venta $venta)
    {
        //
    }

    public function realizarVenta(Request $request)
    {
        $request->validate([
            'dni' => 'nullable|string|max:8',
            'medicamentos' => 'required|array',
            'medicamentos.*.id' => 'required|integer|exists:medicamentos,id',
            'medicamentos.*.cantidad' => 'required|integer|min:1',
            'medicamentos.*.precio_unidad_vender' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0'
        ]);

        \DB::transaction(function () use ($request) {
            // Crear la venta
            $venta = Venta::create([
                'id_usuario' => auth()->id(), // Asumiendo que la venta está asociada con el usuario autenticado
                'dni_comprador' => $request->dni,
                'nombre_comprador' => $request->nombre_comprador ?? null,
                'precio_pagar' => $request->total,
                'fecha' => now(),
                'puntos_extra' => $this->calcularPuntos($request->total)
            ]);

            // Registrar los detalles de la venta
            foreach ($request->medicamentos as $medicamentoData) {
                DetalleVenta::create([
                    'id_venta' => $venta->id,
                    'id_medicamento' => $medicamentoData['id'],
                    'cantidad' => $medicamentoData['cantidad'],
                    'precio_unidad' => $medicamentoData['precio_unidad_vender'],
                    'precio_total' => $medicamentoData['cantidad'] * $medicamentoData['precio_unidad_vender']
                ]);

                // Reducir la cantidad en el stock
                $medicamento = Medicamento::find($medicamentoData['id']);
                $medicamento->cantidad -= $medicamentoData['cantidad'];
                $medicamento->save();
            }

            // Acumular puntos si el cliente tiene DNI
            if ($request->dni) {
                $cliente = Cliente::where('dni', $request->dni)->first();
                if ($cliente) {
                    $cliente->points += $venta->puntos_extra;
                    $cliente->save();
                } else {
                    // Crear un nuevo cliente si no existe
                    Cliente::create([
                        'dni' => $request->dni,
                        'name' => $request->nombre_comprador ?? 'Cliente Nuevo',
                        'points' => $venta->puntos_extra
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Venta realizada con éxito']);
    }



    private function calcularPuntos($total)
    {
        // Lógica para calcular puntos según el total de la venta
        return (int)($total / 5); // Ejemplo: 1 punto por cada 5 soles
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\DetalleVentaMedicamento;
use App\Models\Medicamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicamentos = Medicamento::all();
        return Inertia::render('Medicamentos/Index', [
            'medicamentos' => $medicamentos
        ]);
    }

    public function getTopSellingMedicamentos(Request $request)
    {
        // Validar el intervalo
        $interval = $request->input('interval', '7d');
        
        // Establecer la fecha de inicio según el intervalo
        switch ($interval) {
            case '7d':
                $startDate = Carbon::now()->subDays(7);
                break;
            case '1m':
                $startDate = Carbon::now()->subMonth();
                break;
            case '1y':
                $startDate = Carbon::now()->subYear();
                break;
            default:
                $startDate = Carbon::now()->subDays(7);
        }

        // Obtener los medicamentos más vendidos
        $medicamentos = DetalleVentaMedicamento::select('id_medicamento', DB::raw('SUM(cantidad) as total_vendido'))
            ->join('ventas', 'detalleVentaMedicamento.id_venta', '=', 'ventas.id')
            ->where('ventas.fecha', '>=', $startDate)
            ->groupBy('id_medicamento')
            ->orderBy('total_vendido', 'desc')
            ->get();

        // Obtener detalles de los medicamentos
        $medicamentos = $medicamentos->map(function ($item) {
            $medicamento = Medicamento::find($item->id_medicamento);
            return [
                'nombre' => $medicamento ? $medicamento->nombre : 'Desconocido',
                'total_vendido' => $item->total_vendido
            ];
        });
        return response()->json($medicamentos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Medicamentos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'precio_unidad_vender' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'precio_comprado' => 'required|numeric|min:0',
            'vencimiento' => 'nullable|date',
            'lote' => 'required|string|max:255',
        ]);

        $medicamento = new Medicamento();
        $medicamento->nombre = $request->nombre;
        $medicamento->cantidad = $request->cantidad;
        $medicamento->precio_unidad_vender = $request->precio_unidad_vender;
        $medicamento->precio_venta = $request->precio_venta;
        $medicamento->precio_comprado = $request->precio_comprado;
        $medicamento->vencimiento = $request->vencimiento ? Carbon::parse($request->vencimiento) : null;
        $medicamento->lote = $request->lote;
        $medicamento->save();

        return response()->json(['message' => 'Medicamento agregado exitosamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicamento $medicamento)
    {
        return Inertia::render('Medicamentos/Show', [
            'medicamento' => $medicamento
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicamento $medicamento)
    {
        return Inertia::render('Medicamentos/Edit', [
            'medicamento' => $medicamento
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicamento $medicamento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'precio_unidad_vender' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'precio_comprado' => 'required|numeric',
            'vencimiento' => 'nullable|date',
            'lote' => 'required|string|max:255',
        ]);

        $medicamento->update($request->all());

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicamento $medicamento)
    {
        $medicamento->delete();

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento eliminado exitosamente.');
    }
}

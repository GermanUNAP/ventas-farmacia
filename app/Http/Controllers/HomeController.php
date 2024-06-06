<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Medicamento;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $medicamentos = DB::table('medicamento')->paginate(5);
        return view('home', ['medicamentos' => $medicamentos]);
    }
    public function vender()
    {
        return view('venta');
    }


    public function eliminar(Request $request)
    {
        $ids = $request->input('ids');
        
        // Eliminar los medicamentos con los IDs proporcionados
        Medicamento::whereIn('id', $ids)->delete();

        // Devolver una respuesta de éxito
        return response()->json(['message' => 'Medicamentos eliminados con éxito.']);
    }
    public function buscar(Request $request)
    {
        $query = $request->input('query');

        // Realiza la búsqueda en la base de datos usando $query y devuelve los resultados
        $medicamentos = Medicamento::where('nombre', 'LIKE', "%{$query}%")
                                ->orWhere('id', 'LIKE', "%{$query}%")
                                ->orWhere('lote', 'LIKE', "%{$query}%")
                                ->paginate(5);

        // Si se está realizando una solicitud AJAX, devuelva solo la vista parcial
        if ($request->ajax()) {
            return view('partials.tabla_medicamentos', compact('medicamentos'));
        }

        // Si es una solicitud normal, devuelva la vista completa
        return view('home', compact('medicamentos'));
    }


}

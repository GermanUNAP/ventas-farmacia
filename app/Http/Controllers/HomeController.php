<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicamento;
use Inertia\Inertia;

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
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        // Obtener todos los medicamentos paginados
        $medicamentos = Medicamento::paginate(5);

        // Si se está realizando una solicitud AJAX, devolver solo la vista parcial
        if ($request->ajax()) {
            return view('partials.tabla_medicamentos', compact('medicamentos'));
        }

        // Si es una solicitud normal, devolver la vista completa
        return Inertia::render('Home', [
            'medicamentos' => $medicamentos
        ]);
    }

    /**
     * Handle AJAX request for searching medications.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function buscar(Request $request){
        $query = $request->input('query', '');
        $sortBy = $request->input('sortBy', 'id');
        $descending = $request->input('descending', 'false') === 'true';
        $page = $request->input('page', 1);
        $rowsPerPage = $request->input('rowsPerPage', 5);

        $medicamentos = Medicamento::where(function($q) use ($query) {
                                    $q->where('nombre', 'LIKE', "%{$query}%")
                                    ->orWhere('id', 'LIKE', "%{$query}%")
                                    ->orWhere('lote', 'LIKE', "%{$query}%");
                                })
                                ->orderBy($sortBy, $descending ? 'desc' : 'asc')
                                ->paginate($rowsPerPage, ['*'], 'page', $page);

        if ($request->ajax()) {
            return response()->json($medicamentos);
        }

        return view('home', compact('medicamentos'));
    }



    /**
     * Handle AJAX request for deleting selected medications.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eliminar(Request $request)
    {
        $ids = $request->input('ids');
        
        // Eliminar los medicamentos con los IDs proporcionados
        Medicamento::whereIn('id', $ids)->delete();

        // Devolver una respuesta de éxito
        return response()->json(['message' => 'Medicamentos eliminados con éxito.']);
    }
    public function fetchMedicamentos(Request $request){
        
        try {
            $page = $request->input('page', 1);
            $rowsPerPage = $request->input('rowsPerPage', 10); // Número predeterminado de filas por página
            $sortBy = $request->input('sortBy', 'id'); // Campo por defecto para ordenar
            $descending = $request->input('descending', false);
            $filter = $request->input('filter', '');

            // Construir la consulta para obtener los medicamentos paginados y filtrados
            $query = Medicamento::query();

            // Aplicar filtro si está presente
            if (!empty($filter)) {
                $query->where('nombre', 'LIKE', "%{$filter}%")
                    ->orWhere('id', 'LIKE', "%{$filter}%")
                    ->orWhere('lote', 'LIKE', "%{$filter}%");
            }

            // Ordenar por columna y dirección
            $direction = $descending ? 'desc' : 'asc';
            $query->orderBy($sortBy, $direction);

            // Obtener los medicamentos paginados
            $medicamentos = $query->paginate($rowsPerPage);

            // Devolver los medicamentos paginados como respuesta JSON
            return response()->json($medicamentos);
        } catch (\Exception $e) {
            \Log::error('Error en fetchMedicamentos: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

}

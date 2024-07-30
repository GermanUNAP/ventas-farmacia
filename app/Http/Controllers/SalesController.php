<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $interval = $request->input('interval', '7d'); // Default to '7d' if not provided
        $startDate = Carbon::now();

        switch ($interval) {
            case '1m':
                $startDate = $startDate->subMonth();
                break;
            case '1y':
                $startDate = $startDate->subYear();
                break;
            case '7d':
            default:
                $startDate = $startDate->subDays(6);
                break;
        }

        $sales = Venta::select(DB::raw('DATE(fecha) as date'), DB::raw('SUM(precio_pagar) as total_sales'))
            ->where('fecha', '>=', $startDate)
            ->groupBy(DB::raw('DATE(fecha)'))
            ->orderBy(DB::raw('DATE(fecha)'))
            ->get();

        return response()->json($sales);
    }
}

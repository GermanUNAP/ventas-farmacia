<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\SalesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/about', fn () => Inertia::render('About'))->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('medicamentos', [MedicamentoController::class, 'index'])->name('medicamentos.index');
    Route::get('/sales-data', [SalesController::class, 'index'])->name('sales-data');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Nuevas rutas para medicamentos
    Route::get('medicamentos/create', [MedicamentoController::class, 'create'])->name('medicamentos.create');
    Route::post('medicamentos', [MedicamentoController::class, 'store'])->name('medicamentos.store');
    Route::get('medicamentos/{medicamento}', [MedicamentoController::class, 'show'])->name('medicamentos.show');
    Route::get('medicamentos/{medicamento}/edit', [MedicamentoController::class, 'edit'])->name('medicamentos.edit');
    Route::put('medicamentos/{medicamento}', [MedicamentoController::class, 'update'])->name('medicamentos.update');
    Route::delete('medicamentos/{medicamento}', [MedicamentoController::class, 'destroy'])->name('medicamentos.destroy');
    Route::get('/top-selling-medicamentos', [MedicamentoController::class, 'getTopSellingMedicamentos'])->name('top-selling-medicamentos');
    Route::get('buscar-medicamentos', [HomeController::class, 'buscar'])->name('medicamentos.buscar');
    Route::get('fetch-medicamentos', [HomeController::class, 'fetchMedicamentos'])->name('medicamentos.fetch');
    Route::post('realizar-venta', [VentaController::class, 'realizarVenta'])->name('realizar-venta');
});

require __DIR__.'/auth.php';

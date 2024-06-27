<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post("/login",[App\Http\Controllers\LoginController::class, "login"])->name('login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/vender', [App\Http\Controllers\HomeController::class, 'vender'])->name('vender');

//CRUD part
Route::post("/delete",[App\Http\Controllers\DataController::class, "destroy"])->name('delete');
Route::get('/buscar-medicamentos', [App\Http\Controllers\HomeController::class, 'buscar']);
Route::post('/eliminar-medicamentos', [App\Http\Controllers\HomeController::class, 'eliminarMedicamentos'])->name('eliminar.medicamentos');
Route::post('/realizar-venta', [App\Http\Controllers\VentaController::class, 'realizarVenta']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CreacionController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;


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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/categorias',[App\Http\Controllers\CategoriaController::class,'index'])->name("categorias");
Route::get('/clientes',[App\Http\Controllers\ClienteController::class,'index'])->name("clientes");
Route::get('/articulos',[App\Http\Controllers\ArticuloController::class,'index'])->name("articulos");
Route::get('/colores',[App\Http\Controllers\ColorController::class,'index'])->name("colores");
Route::get('/compras',[App\Http\Controllers\CompraController::class,'index'])->name("compras");
Route::get('/creaciones',[App\Http\Controllers\CreacionController::class,'index'])->name("creaciones");
Route::get('/pedidos',[App\Http\Controllers\PedidoController::class,'index'])->name("pedidos");
Route::get('/proveedores',[App\Http\Controllers\ProveedorController::class,'index'])->name("proveedores");
Route::get('/ventas',[App\Http\Controllers\VentaController::class,'index'])->name("ventas");
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

//Retorno de una vista
Route::get('/', function () {
    return view('welcome');
});

/**
 * Rutas para categorias
 */

Route::get('/categorias',[CategoriaController::class,'index'])->name("categorias");

Route::get('/categorias/all',[CategoriaController::class,'show']);

Route::post('/categorias/save',[CategoriaController::class,'store']);

Route::put('/categorias/update',[CategoriaController::class,'update']);

Route::post('/categorias/delete',[CategoriaController::class,'destroy']);


/**
 * Rutas para clientes
 */

Route::get('/clientes',[clienteController::class,'index'])->name("clientes");

Route::get('/clientes/all',[clienteController::class,'show']);

Route::post('/clientes/save',[clienteController::class,'store']);

Route::put('/clientes/update',[clienteController::class,'update']);

Route::post('/clientes/delete',[clienteController::class,'destroy']);


/**
 * Rutas para articulos
 */

Route::get('/articulos',[ArticuloController::class,'index'])->name("articulos");

Route::get('/articulos/all',[ArticuloController::class,'show']);

Route::post('/articulos/save',[ArticuloController::class,'store']);

Route::put('/articulos/update',[ArticuloController::class,'update']);

Route::post('/articulos/delete',[ArticuloController::class,'destroy']);

Route::get('/articulos/pdf',[PDFController::class,'pdfArticulos'])->name('pdfArticulos');


/**
 * Rutas para colores
 */

Route::get('/colores',[ColorController::class,'index'])->name("colores");

Route::get('/colores/all',[ColorController::class,'show']);

Route::post('/colores/save',[ColorController::class,'store']);

Route::put('/colores/update',[ColorController::class,'update']);

Route::post('/colores/delete',[ColorController::class,'destroy']);


/**
 * Rutas para compras
 */

Route::get('/compras',[CompraController::class,'index'])->name("compras");

Route::get('/compras/all',[CompraController::class,'show']);

Route::post('/compras/save',[CompraController::class,'store']);

Route::put('/compras/update',[CompraController::class,'update']);

Route::post('/compras/delete',[CompraController::class,'destroy']);


/**
 * Rutas para creaciones
 */

Route::get('/creaciones',[CreacionController::class,'index'])->name("creaciones");

Route::get('/creaciones/all',[CreacionController::class,'show']);

Route::post('/creaciones/save',[CreacionController::class,'store']);

Route::put('/creaciones/update',[CreacionController::class,'update']);

Route::post('/creaciones/delete',[CreacionController::class,'destroy']);


/**
 * Rutas para pedidos
 */

Route::get('/pedidos',[PedidoController::class,'index'])->name("reservas");

Route::get('/pedidos/state',[PedidoController::class,'show']);

Route::post('/pedidos/save',[PedidoController::class,'store']);

Route::put('/pedidos/change',[PedidoController::class,'changeState']);


/**
 * Rutas para proveedores
 */

Route::get('/proveedores',[ProveedorController::class,'index'])->name("proveedores");

Route::get('/proveedores/all',[ProveedorController::class,'show']);

Route::post('/proveedores/save',[ProveedorController::class,'store']);

Route::put('/proveedores/update',[ProveedorController::class,'update']);

Route::post('/proveedores/delete',[ProveedorController::class,'destroy']);


/**
 * Rutas para ventas
 */

Route::get('/ventas',[VentaController::class,'index'])->name("ventas");

Route::get('/ventas/all',[VentaController::class,'show']);

Route::post('/ventas/save',[VentaController::class,'store']);

Route::put('/ventas/update',[VentaController::class,'update']);

Route::post('/ventas/delete',[VentaController::class,'destroy']);


/**
 * Rutas para home
 */


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/reportes',[ReporteController::class,'index'])->name("reportes");
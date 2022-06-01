<?php

use Illuminate\Http\Request;
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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

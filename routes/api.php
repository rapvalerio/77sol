<?php

use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\InstalacaoController;
use App\Http\Controllers\ProjetoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('clientes', ClienteController::class);
Route::apiResource('equipamentos', EquipamentoController::class);
Route::apiResource('enderecos', EnderecoController::class);
Route::apiResource('instalacoes', InstalacaoController::class);
Route::apiResource('projetos', ProjetoController::class);
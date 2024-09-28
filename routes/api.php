<?php

use App\Http\Controllers\EnderecosController;
use App\Http\Controllers\EquipamentosController;
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

//Endpoint para o cliente
Route::get('/cliente', [ClienteController::class, 'index']);
Route::get('/cliente/{id}', [ClienteController::class, 'show']);
Route::post('/cliente', [ClienteController::class, 'store']);
Route::put('/cliente/{id}', [ClienteController::class, 'update']);
Route::delete('/cliente/{id}', [ClienteController::class, 'destroy']);

//Endpoint para o equipamento
Route::get('/equipamento', [EquipamentosController::class, 'index']);
Route::get('/equipamento/{id}', [EquipamentosController::class, 'show']);
Route::post('/equipamento', [EquipamentosController::class, 'store']);
Route::put('/equipamento/{id}', [EquipamentosController::class, 'update']);
Route::delete('/equipamento/{id}', [EquipamentosController::class, 'destroy']);

//Endpoint para o endereco
Route::get('/endereco', [EnderecosController::class, 'index']);
Route::get('/endereco/{id}', [EnderecosController::class, 'show']);
Route::post('/endereco', [EnderecosController::class, 'store']);
Route::put('/endereco/{id}', [EnderecosController::class, 'update']);
Route::delete('/endereco/{id}', [EnderecosController::class, 'destroy']);

//Endpoint para a instalacao
Route::get('/instalacao', [InstalacaoController::class, 'index']);
Route::get('/instalacao/{id}', [InstalacaoController::class, 'show']);
Route::post('/instalacao', [InstalacaoController::class, 'store']);
Route::put('/instalacao/{id}', [InstalacaoController::class, 'update']);
Route::delete('/instalacao/{id}', [InstalacaoController::class, 'destroy']);

//Endpoint para o projetos
Route::get('/projetos', [ProjetoController::class, 'index']);
Route::get('/projetos/{id}', [ProjetoController::class, 'show']);
Route::post('/projetos', [ProjetoController::class, 'store']);
Route::put('/projetos/{id}', [ProjetoController::class, 'update']);
Route::delete('/projetos/{id}', [ProjetoController::class, 'destroy']);
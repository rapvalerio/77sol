<?php

namespace App\Http\Controllers;

use App\Services\ProjetoEquipamentoServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjetoEquipamentoController extends Controller
{
    public $service;

    public function __construct(ProjetoEquipamentoServices $projetoEquipamentoServices){
        $this->service = $projetoEquipamentoServices;
    }

    public function index()
    {
        return response()->json($this->service->buscar(), 200);
    }

    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'projeto_id' => 'required|exists:projetos,id',
                'equipamento_id' => 'required|exists:equipamentos,id',
                'quantidade' => 'required|int|min:1',
            ]);
            
            return response()->json($this->service->criar($validatedData), 201);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    public function show(string $id)
    {
        try {
            return response()->json($this->service->buscar($id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Equipamentos do projeto não encontrados'], 404);
        }
    }

    
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'projeto_id' => 'sometimes|required|exists:projetos,id',
                'equipamento_id' => 'sometimes|required|exists:equipamentos,id',
                'quantidade' => 'sometimes|required|int|min:1',
            ]);
            return response()->json($this->service->editar($validatedData, $id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Equipamento do projeto não encontrados'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o projeto: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            return response()->json($this->service->remover($id),200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Equipamento do projeto não encontrados'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar o projeto: ' . $e->getMessage()], 500);
        }
    }
}

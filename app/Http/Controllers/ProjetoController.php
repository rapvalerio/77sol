<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    /**
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clientes = Projeto::with('equipamentos')->get();
        return response()->json($clientes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // var_dump($request->equipamento);die;
        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'cliente_id' => 'required|exists:clientes,id',
            'endereco_id' => 'required|exists:enderecos,id',
            'instalacao_id' => 'required|exists:instalacoes,id',
            'equipamentos' => 'required|array',
            'equipamentos.*.equipamento_id' => 'required|exists:equipamentos,id',
            'equipamentos.*.quantidade' => 'required|integer|min:1',
        ]);

        try{
            $projeto = Projeto::create($validatedData);

            // Associar os equipamentos ao projeto na tabela intermediária
            $equipamentos = [];
            foreach ($request->equipamentos as $equipamento) {
                $equipamentos[$equipamento['equipamento_id']] = ['quantidade' => $equipamento['quantidade']];
            }
    
            // Usar sync() para associar equipamentos na tabela intermediária
            $projeto->equipamentos()->sync($equipamentos);
    
            return response()->json($projeto->load('equipamentos'), 201);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], status:500);
        }
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        try {
            $projeto = Projeto::findOrFail($id);
            return response()->json($projeto);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        try {
            $projeto = Projeto::findOrFail($id);

            $validatedData = $request->validate([
                'nome' => 'sometimes|required|string|max:100',
                'cliente_id' => 'sometimes|required|exists:clientes,id',
                'endereco_id' => 'sometimes|required|exists:enderecos,id',
                'instalacao_id' => 'sometimes|required|exists:instalacoes,id',
                'equipamentos' => 'required|array',
                'equipamentos.*.equipamento_id' => 'required|exists:equipamentos,id',
                'equipamentos.*.quantidade' => 'required|integer|min:1',
            ]);

            $projeto->update($validatedData);

            $projetoData = $request->only(['nome', 'cliente_id', 'endereco_id', 'instalacao_id']);
            $projeto->update($projetoData);

            if($request->has('equipamentos')){
                $equipamentos = [];
                foreach ($request->equipamentos as $equipamento) {
                    $equipamentos[$equipamento['equipamento_id']] = ['quantidade' => $equipamento['quantidade']];
                }
    
                // Sincronizar os equipamentos com as quantidades na tabela intermediária
                $projeto->equipamentos()->sync($equipamentos);
            }

            return response()->json($projeto->load('equipamentos'), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Projetos não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o projeto: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            $projeto = Projeto::findOrFail($id);
            $projeto->delete();
            return response()->json(['Projetos deletado com sucesso'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Projetos não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar o projeto: ' . $e->getMessage()], 500);
        }
    }
}

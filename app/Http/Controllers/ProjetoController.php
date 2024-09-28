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
        $clientes = Projeto::all();
        return response()->json($clientes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'cliente_id' => 'required|exists:clientes,id',
            'endereco_id' => 'required|exists:enderecos,id',
            'instalacao_id' => 'required|exists:instalacoes,id',
        ]);

        try{
            $endereco = Projeto::create($validatedData);
            return response()->json($endereco, 201);
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
            $clientes = Projeto::findOrFail($id);
            return response()->json($clientes);
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
            $cliente = Projeto::findOrFail($id);

            $validatedData = $request->validate([
                'nome' => 'sometimes|required|string|max:100',
                'cliente_id' => 'sometimes|required|exists:clientes,id',
                'endereco_id' => 'sometimes|required|exists:enderecos,id',
                'instalacao_id' => 'sometimes|required|exists:instalacoes,id',
            ]);

            $cliente->update($validatedData);
            return response()->json($cliente, 200);
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
            $cliente = Projeto::findOrFail($id);
            $cliente->delete();
            return response()->json(['Projetos deletado com sucesso'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Projetos não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar o projeto: ' . $e->getMessage()], 500);
        }
    }
}

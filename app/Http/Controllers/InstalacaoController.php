<?php

namespace App\Http\Controllers;

use App\Models\Instalacao;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class InstalacaoController extends Controller
{
    /**
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clientes = Instalacao::all();
        return response()->json($clientes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'descricao' => 'required|string|max:100',
        ]);

        try{
            $endereco = Instalacao::create($validatedData);
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
            $clientes = Instalacao::findOrFail($id);
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
        try{
            $cliente = Instalacao::findOrFail($id);

            $validatedData = $request->validate([
                'descricao' => 'required|string|max:100',
            ]);

            $cliente->update($validatedData);
            return response()->json($cliente, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Instalação não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar a instalação: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try{
            $cliente = Instalacao::findOrFail($id);
            $cliente->delete();
            return response()->json(['Instalação deletado com sucesso'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Instalação não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar a instalação: ' . $e->getMessage()], 500);
        }
    }
}

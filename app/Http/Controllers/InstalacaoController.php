<?php

namespace App\Http\Controllers;

use App\Models\Instalacoes;
use Illuminate\Http\Request;

class InstalacaoController extends Controller
{
    /**
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clientes = Instalacoes::all();
        return response()->json($clientes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try{
            $endereco = Instalacoes::create($request->all());
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
            $clientes = Instalacoes::findOrFail($id);
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
        $cliente = Instalacoes::find($id);

        if ($cliente) {
            $cliente->update($request->all());
            return response()->json($cliente);
        } else {
            return response()->json(['message' => 'Instalação não encontrado'], 404);
        }
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $cliente = Instalacoes::find($id);

        if ($cliente) {
            $cliente->delete();
            return response()->json(['Instalação deletado com sucesso'],200);
        } else {
            return response()->json(['message' => 'Instalação não encontrado'], 404);
        }
    }
}

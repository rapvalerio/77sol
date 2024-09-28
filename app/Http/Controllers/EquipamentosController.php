<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipamentos;

class EquipamentosController extends Controller
{
    /**
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clientes = Equipamentos::all();
        return response()->json($clientes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try{
            $equipamento = Equipamentos::create($request->all());
            return response()->json($equipamento, 201);
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
            $clientes = Equipamentos::findOrFail($id);
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
        $cliente = Equipamentos::find($id);

        if ($cliente) {
            $cliente->update($request->all());
            return response()->json($cliente);
        } else {
            return response()->json(['message' => 'Equipamento não encontrado'], 404);
        }
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $cliente = Equipamentos::find($id);

        if ($cliente) {
            $cliente->delete();
            return response()->json(['Equipamento deletado com sucesso'],200);
        } else {
            return response()->json(['message' => 'equipamento not found'], 404);
        }
    }
}

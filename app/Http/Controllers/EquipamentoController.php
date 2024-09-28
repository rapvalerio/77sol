<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Equipamento;

class EquipamentoController extends Controller
{
    /**
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clientes = Equipamento::all();
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
            $equipamento = Equipamento::create($validatedData);
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
            $clientes = Equipamento::findOrFail($id);
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
            $cliente = Equipamento::findOrFail($id);

            $validatedData = $request->validate([
                'descricao' => 'required|string|max:100',
            ]);

            $cliente->update($validatedData);
            return response()->json($cliente, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'equipamento not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao atualizar o equipamento: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try{
            $cliente = Equipamento::findOrFail($id);
            $cliente->delete();
            return response()->json(['Equipamento deletado com sucesso'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'equipamento not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao deletetar equipamento: ' . $e->getMessage()], 500);
        }
    }
}

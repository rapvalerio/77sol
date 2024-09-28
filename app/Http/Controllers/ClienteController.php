<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Clientes::all();
        return response()->json($clientes);
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        try {
            $clientes = Clientes::findOrFail($id);
            return response()->json($clientes);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try{
            $cliente = Clientes::create($request->all());
            return response()->json($cliente, 201);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $cliente = Clientes::find($id);

        if ($cliente) {
            $cliente->update($request->all());
            return response()->json($cliente);
        } else {
            return response()->json(['message' => 'cliente not found'], 404);
        }
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $cliente = Clientes::find($id);

        if ($cliente) {
            $cliente->delete();
            return response()->json(['Cliente deletado com sucesso'],200);
        } else {
            return response()->json(['message' => 'cliente não encontrado'], 404);
        }
    }
}

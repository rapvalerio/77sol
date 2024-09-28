<?php

namespace App\Http\Controllers;

use App\Rules\CpfCnpj;
use App\Rules\Documento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        try {
            $clientes = Cliente::findOrFail($id);
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
        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'telefone' => 'required|string|max:20',
            'documento' => ['required','string','max:20', new Documento],
        ]);

        try{
            $cliente = Cliente::create($validatedData);
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
        try {
            $cliente = Cliente::findOrFail($id);

            $validatedData = $request->validate([
                'nome' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'telefone' => 'required|string|max:20',
                'documento' => ['required','string','max:20', new Documento]
            ]);

            $cliente->update($validatedData);
            return response()->json($cliente,200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);            
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao atualizar cliente: '.$e->getMessage()], 500);
        }
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();
            return response()->json(['Cliente deletado com sucesso'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);            
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao deletar cliente: '.$e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clientes = Endereco::all();
        return response()->json($clientes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'uf' => 'required|string|size:2|in:SP,RJ,AM,BA,MG,ES,SC,RS,PR,PE,PB,AL,SE,DF,GO,MT,MS,TO,MA,PI,CE,RN,PA,AP,RR,RO,AC',
        ]);

        try{
            $endereco = Endereco::create($validatedData);
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
            $clientes = Endereco::findOrFail($id);
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
            $cliente = Endereco::findOrFail($id);

            $validatedData = $request->validate([
                'uf' => 'sometimes|required|string|size:2|in:SP,RJ,AM,BA,MG,ES,SC,RS,PR,PE,PB,AL,SE,DF,GO,MT,MS,TO,MA,PI,CE,RN,PA,AP,RR,RO,AC',
            ]);


            $cliente->update($validatedData);
            return response()->json($cliente, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Endereço não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o endereço: ' . $e->getMessage()], 500);

        }
    }

    /**
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            $cliente = Endereco::findOrFail($id);
            $cliente->delete();
            return response()->json(['Endereço deletado com sucesso'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Endereço não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar o endereço: ' . $e->getMessage()], 500);
        }
    }
}

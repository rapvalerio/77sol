<?php

namespace App\Http\Controllers;

use App\Rules\Documento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clientes",
     *     summary="Listar todos os clientes",
     *     tags={"Clientes"},
     *     description="Retorna uma lista de todos os clientes.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Cliente")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    /**
     * @OA\Get(
     *     path="/api/clientes/{id}",
     *     summary="Obter detalhes de um cliente",
     *     tags={"Clientes"},
     *     description="Retorna os detalhes de um cliente específico baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do cliente",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do cliente",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente não encontrado")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/clientes",
     *     summary="Criar um novo cliente",
     *     tags={"Clientes"},
     *     description="Cria um novo cliente com os dados fornecidos.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "email", "telefone", "documento"},
     *             @OA\Property(property="nome", type="string", example="João Silva"),
     *             @OA\Property(property="email", type="string", example="joao@email.com"),
     *             @OA\Property(property="telefone", type="string", example="(11) 99999-9999"),
     *             @OA\Property(property="documento", type="string", example="12345678901")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao criar cliente",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao criar cliente")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'nome' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'telefone' => 'required|string|max:20',
                'documento' => ['required','string','max:20', new Documento],
            ]);
            
            $cliente = Cliente::create($validatedData);
            return response()->json($cliente, 201);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/clientes/{id}",
     *     summary="Atualizar um cliente",
     *     tags={"Clientes"},
     *     description="Atualiza os dados de um cliente existente baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do cliente a ser atualizado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "email", "telefone", "documento"},
     *             @OA\Property(property="nome", type="string", example="João Silva"),
     *             @OA\Property(property="email", type="string", example="joao@email.com"),
     *             @OA\Property(property="telefone", type="string", example="(11) 99999-9999"),
     *             @OA\Property(property="documento", type="string", example="12345678901")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente não encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar cliente",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao atualizar cliente")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/clientes/{id}",
     *     summary="Deletar um cliente",
     *     tags={"Clientes"},
     *     description="Deleta um cliente existente baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do cliente a ser deletado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente deletado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente deletado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente não encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar cliente",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao deletar cliente")
     *         )
     *     )
     * )
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

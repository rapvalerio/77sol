<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/enderecos",
     *     summary="Listar todos os endereços",
     *     tags={"Endereços"},
     *     description="Retorna uma lista de todos os endereços.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de endereços",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Endereco")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $clientes = Endereco::all();
        return response()->json($clientes);
    }

    /**
     * @OA\Post(
     *     path="/api/enderecos",
     *     summary="Criar um novo endereço",
     *     tags={"Endereços"},
     *     description="Cria um novo endereço com os dados fornecidos.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"uf"},
     *             @OA\Property(property="uf", type="string", example="SP", description="UF do endereço")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Endereço criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Endereco")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao criar endereço",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao criar endereço")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'uf' => 'required|string|size:2|in:SP,RJ,AM,BA,MG,ES,SC,RS,PR,PE,PB,AL,SE,DF,GO,MT,MS,TO,MA,PI,CE,RN,PA,AP,RR,RO,AC',
            ]);
            
            $endereco = Endereco::create($validatedData);
            return response()->json($endereco, 201);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], status:500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/enderecos/{id}",
     *     summary="Obter detalhes de um endereço",
     *     tags={"Endereços"},
     *     description="Retorna os detalhes de um endereço específico baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do endereço",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do endereço",
     *         @OA\JsonContent(ref="#/components/schemas/Endereco")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Endereço não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Endereço não encontrado")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/enderecos/{id}",
     *     summary="Atualizar um endereço",
     *     tags={"Endereços"},
     *     description="Atualiza os dados de um endereço existente baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do endereço a ser atualizado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"uf"},
     *             @OA\Property(property="uf", type="string", example="SP", description="UF do endereço")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Endereco")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Endereço não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Endereço não encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar endereço",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao atualizar endereço")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/enderecos/{id}",
     *     summary="Deletar um endereço",
     *     tags={"Endereços"},
     *     description="Deleta um endereço existente baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do endereço a ser deletado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço deletado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Endereço deletado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Endereço não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Endereço não encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar endereço",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao deletar endereço")
     *         )
     *     )
     * )
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

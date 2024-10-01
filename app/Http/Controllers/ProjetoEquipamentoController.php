<?php

namespace App\Http\Controllers;

use App\Services\ProjetoEquipamentoServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjetoEquipamentoController extends Controller
{
    public $service;

    public function __construct(ProjetoEquipamentoServices $projetoEquipamentoServices){
        $this->service = $projetoEquipamentoServices;
    }

    /**
     * @OA\Get(
     *     path="/api/projetos-equipamentos",
     *     summary="Obter a lista de todos os registros de projetos e seus equipamentos",
     *     tags={"ProjetosEquipamento"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de todos os registros de projetos e seus equipamentos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="projeto_id", type="integer", example=1),
     *                 @OA\Property(property="equipamento_id", type="integer", example=1),
     *                 @OA\Property(property="quantidade", type="integer", example=5),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-30T00:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-30T00:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao obter a lista"
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->service->buscar(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/projetos-equipamentos",
     *     summary="Criar uma nova associação entre projeto e equipamento",
     *     tags={"ProjetosEquipamento"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="projeto_id", type="integer", example=1),
     *             @OA\Property(property="equipamento_id", type="integer", example=1),
     *             @OA\Property(property="quantidade", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Associação criada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="projeto_id", type="integer", example=1),
     *             @OA\Property(property="equipamento_id", type="integer", example=1),
     *             @OA\Property(property="quantidade", type="integer", example=5),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-30T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-30T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dados inválidos fornecidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno ao criar a associação",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao criar a associação")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'projeto_id' => 'required|exists:projetos,id',
                'equipamento_id' => 'required|exists:equipamentos,id',
                'quantidade' => 'required|int|min:1',
            ]);
            
            return response()->json($this->service->criar($validatedData), 201);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/projetos-equipamentos/{id}",
     *     summary="Obter equipamentos associados a um projeto",
     *     tags={"ProjetosEquipamento"},
     *     description="Retorna a associação de equipamentos para um projeto específico com base no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do projeto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipamentos associados ao projeto",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="projeto_id", type="integer", example=1),
     *             @OA\Property(property="equipamento_id", type="integer", example=1),
     *             @OA\Property(property="quantidade", type="integer", example=5),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-30T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-30T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipamentos do projeto não encontrados",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipamentos do projeto não encontrados")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            return response()->json($this->service->buscar($id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Equipamentos do projeto não encontrados'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/projetos-equipamentos/{id}",
     *     summary="Atualizar equipamento associado a um projeto",
     *     tags={"ProjetosEquipamento"},
     *     description="Atualiza os dados de um equipamento associado a um projeto com base no ID fornecido. Permite atualizar o projeto_id, equipamento_id e a quantidade.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do equipamento do projeto a ser atualizado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="projeto_id", type="integer", example=1),
     *             @OA\Property(property="equipamento_id", type="integer", example=2),
     *             @OA\Property(property="quantidade", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipamento do projeto atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="projeto_id", type="integer", example=1),
     *             @OA\Property(property="equipamento_id", type="integer", example=2),
     *             @OA\Property(property="quantidade", type="integer", example=10),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-30T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-30T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipamento do projeto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipamento do projeto não encontrados")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar o projeto",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao atualizar o projeto")
     *         )
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'projeto_id' => 'sometimes|required|exists:projetos,id',
                'equipamento_id' => 'sometimes|required|exists:equipamentos,id',
                'quantidade' => 'sometimes|required|int|min:1',
            ]);
            return response()->json($this->service->editar($validatedData, $id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Equipamentos do projeto não encontrados'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o projeto: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/projetos-equipamentos/{id}",
     *     summary="Deletar equipamento associado a um projeto",
     *     tags={"ProjetosEquipamento"},
     *     description="Deleta um equipamento associado a um projeto com base no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do equipamento do projeto a ser deletado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipamento do projeto deletado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipamento do projeto deletado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipamento do projeto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipamento do projeto não encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar o equipamento do projeto",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao deletar o projeto")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            return response()->json($this->service->remover($id),200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Equipamento do projeto não encontrados'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar o projeto: ' . $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Equipamento;
use App\Services\EquipamentoServices;
use Illuminate\Validation\ValidationException;

class EquipamentoController extends Controller
{
    public $equipamentoService;

    public function __construct(EquipamentoServices $equipamentoService){
        $this->equipamentoService = $equipamentoService;
    }

    /**
     * @OA\Get(
     *     path="/api/equipamentos",
     *     summary="Listar todos os equipamentos",
     *     tags={"Equipamentos"},
     *     description="Retorna uma lista de todos os equipamentos.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de equipamentos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Equipamento")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->equipamentoService->buscaEquipamento(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/equipamentos",
     *     summary="Criar um novo equipamento",
     *     tags={"Equipamentos"},
     *     description="Cria um novo equipamento com os dados fornecidos.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"descricao"},
     *             @OA\Property(property="descricao", type="string", example="Inversor", description="Descrição do equipamento")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Equipamento criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Equipamento")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao criar equipamento",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao criar equipamento")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'descricao' => 'required|string|max:100',
            ]);
            
            return response()->json($this->equipamentoService->criaEquipamento($validatedData), 201);
        } catch(ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], status:500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/equipamentos/{id}",
     *     summary="Obter detalhes de um equipamento",
     *     tags={"Equipamentos"},
     *     description="Retorna os detalhes de um equipamento específico baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do equipamento",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do equipamento",
     *         @OA\JsonContent(ref="#/components/schemas/Equipamento")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipamento não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipamento não encontrado")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            return response()->json($this->equipamentoService->buscaEquipamento($id), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/equipamentos/{id}",
     *     summary="Atualizar um equipamento",
     *     tags={"Equipamentos"},
     *     description="Atualiza os dados de um equipamento existente baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do equipamento a ser atualizado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"descricao"},
     *             @OA\Property(property="descricao", type="string", example="Microinversor", description="Descrição do equipamento")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipamento atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Equipamento")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipamento não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipamento não encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar equipamento",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao atualizar equipamento")
     *         )
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        try{
            $validatedData = $request->validate([
                'descricao' => 'required|string|max:100',
            ]);

            return response()->json($this->equipamentoService->editaEquipamento($validatedData, $id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Equipamento não encontrado'], 404);
        } catch(ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao atualizar o equipamento: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/equipamentos/{id}",
     *     summary="Deletar um equipamento",
     *     tags={"Equipamentos"},
     *     description="Deleta um equipamento existente baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do equipamento a ser deletado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipamento deletado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipamento deletado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipamento não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Equipamento não encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar equipamento",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao deletar equipamento")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try{
            return response()->json($this->equipamentoService->removerEquipamento($id),200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'equipamento não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao deletar equipamento: ' . $e->getMessage()], 500);
        }
    }
}

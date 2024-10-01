<?php

namespace App\Http\Controllers;

use App\Services\Projeto;
use App\Services\ProjetoServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * @OA\PathItem(
 *     path="/api/projetos"
 * )
 */

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Documentação da API de Gestão de Projetos",
 *      description="Documentação da API para o sistema de gestão de projetos de energia solar",
 * )
 */

class ProjetoController extends Controller
{
    public $service;

    public function __construct(ProjetoServices $service){
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/projetos",
     *     summary="Listar todos os projetos, com opção de filtragem por nome",
     *     tags={"Projetos"},
     *     @OA\Parameter(
     *         name="nome",
     *         in="query",
     *         required=false,
     *         description="Filtrar projetos pelo nome. Utiliza busca parcial (like)",
     *         @OA\Schema(
     *             type="string",
     *             example="Fazenda"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de projetos filtrados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Fazenda Solar"),
     *                 @OA\Property(property="cliente_id", type="integer", example=1),
     *                 @OA\Property(property="endereco_id", type="integer", example=1),
     *                 @OA\Property(property="instalacao_id", type="integer", example=1),
     *                 @OA\Property(property="equipamentos", type="array", @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="descricao", type="string", example="Módulo"),
     *                     @OA\Property(property="quantidade", type="integer", example=5)
     *                 )),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-29T00:37:06.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-29T00:37:06.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao listar projetos"
     *     )
     * )
     */
    public function index(Request $request)
    {
        return response()->json($this->service->buscaProjeto($request->all()), 200);
    }
    
    /**
     * @OA\Post(
     *     path="/api/projetos",
     *     summary="Criar um novo projeto",
     *     tags={"Projetos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="Fazenda Solar"),
     *             @OA\Property(property="cliente_id", type="integer", example=1),
     *             @OA\Property(property="endereco_id", type="integer", example=1),
     *             @OA\Property(property="instalacao_id", type="integer", example=1),
     *             @OA\Property(property="equipamentos", type="array", @OA\Items(
     *                 @OA\Property(property="equipamento_id", type="integer", example=1),
     *                 @OA\Property(property="quantidade", type="integer", example=1)
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Projeto criado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao criar projeto"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'nome' => 'required|string|max:100',
                'cliente_id' => 'required|exists:clientes,id',
                'endereco_id' => 'required|exists:enderecos,id',
                'instalacao_id' => 'required|exists:instalacoes,id',
                // 'equipamentos' => 'required|array',
                // 'equipamentos.*.equipamento_id' => 'required|exists:equipamentos,id',
                // 'equipamentos.*.quantidade' => 'required|integer|min:1',
            ]);
    
            return response()->json($this->service->criaProjeto($validatedData), 201);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], status:500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/projetos/{id}",
     *     summary="Obter detalhes de um projeto",
     *     tags={"Projetos"},
     *     description="Retorna os detalhes de um projeto específico baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do projeto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do projeto",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nome", type="string", example="Fazenda Solar"),
     *             @OA\Property(property="cliente_id", type="integer", example=1),
     *             @OA\Property(property="endereco_id", type="integer", example=1),
     *             @OA\Property(property="instalacao_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-29T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-29T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Projeto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Projeto não encontrado")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            return response()->json($this->service->buscaProjeto(['id' => $id]), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Projeto não encontrado'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/projetos/{id}",
     *     summary="Atualizar um projeto existente",
     *     tags={"Projetos"},
     *     description="Atualiza os dados de um projeto com base no ID fornecido. Também permite atualizar os equipamentos associados ao projeto.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do projeto a ser atualizado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="Fazenda Solar Atualizada"),
     *             @OA\Property(property="cliente_id", type="integer", example=1),
     *             @OA\Property(property="endereco_id", type="integer", example=1),
     *             @OA\Property(property="instalacao_id", type="integer", example=1),
     *             @OA\Property(property="equipamentos", type="array", @OA\Items(
     *                 @OA\Property(property="equipamento_id", type="integer", example=1),
     *                 @OA\Property(property="quantidade", type="integer", example=5)
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Projeto atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nome", type="string", example="Fazenda Solar Atualizada"),
     *             @OA\Property(property="cliente_id", type="integer", example=1),
     *             @OA\Property(property="endereco_id", type="integer", example=1),
     *             @OA\Property(property="instalacao_id", type="integer", example=1),
     *             @OA\Property(
     *                 property="equipamentos",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="equipamento_id", type="integer", example=1),
     *                     @OA\Property(property="quantidade", type="integer", example=5)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Projeto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Projeto não encontrado")
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
                'nome' => 'sometimes|required|string|max:100',
                'cliente_id' => 'sometimes|required|exists:clientes,id',
                'endereco_id' => 'sometimes|required|exists:enderecos,id',
                'instalacao_id' => 'sometimes|required|exists:instalacoes,id',
                // 'equipamentos' => 'required|array',
                // 'equipamentos.*.equipamento_id' => 'required|exists:equipamentos,id',
                // 'equipamentos.*.quantidade' => 'required|integer|min:1',
            ]);
            return response()->json($this->service->editaProjeto($validatedData, $id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Projetos não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o projeto: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/projetos/{id}",
     *     summary="Deletar um projeto",
     *     tags={"Projetos"},
     *     description="Deleta um projeto específico baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do projeto a ser deletado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Projeto deletado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Projetos deletado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Projeto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Projetos não encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar o projeto",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao deletar o projeto")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            return response()->json($this->service->removerProjeto($id),200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Projetos não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar o projeto: ' . $e->getMessage()], 500);
        }
    }
}

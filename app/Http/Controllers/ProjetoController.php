<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
    /**
     * @OA\Get(
     *     path="/api/projetos",
     *     summary="Listar todos os projetos",
     *     tags={"Projetos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de projetos"
     *     )
     * )
     */
    public function index()
    {
        $clientes = Projeto::with('equipamentos')->get();
        return response()->json($clientes);
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
        // var_dump($request->equipamento);die;
        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'cliente_id' => 'required|exists:clientes,id',
            'endereco_id' => 'required|exists:enderecos,id',
            'instalacao_id' => 'required|exists:instalacoes,id',
            'equipamentos' => 'required|array',
            'equipamentos.*.equipamento_id' => 'required|exists:equipamentos,id',
            'equipamentos.*.quantidade' => 'required|integer|min:1',
        ]);

        try{
            $projeto = Projeto::create($validatedData);

            // Associar os equipamentos ao projeto na tabela intermediária
            $equipamentos = [];
            foreach ($request->equipamentos as $equipamento) {
                $equipamentos[$equipamento['equipamento_id']] = ['quantidade' => $equipamento['quantidade']];
            }
    
            // Usar sync() para associar equipamentos na tabela intermediária
            $projeto->equipamentos()->sync($equipamentos);
    
            return response()->json($projeto->load('equipamentos'), 201);
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
            $projeto = Projeto::findOrFail($id);
            return response()->json($projeto);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
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
            $projeto = Projeto::findOrFail($id);

            $validatedData = $request->validate([
                'nome' => 'sometimes|required|string|max:100',
                'cliente_id' => 'sometimes|required|exists:clientes,id',
                'endereco_id' => 'sometimes|required|exists:enderecos,id',
                'instalacao_id' => 'sometimes|required|exists:instalacoes,id',
                'equipamentos' => 'required|array',
                'equipamentos.*.equipamento_id' => 'required|exists:equipamentos,id',
                'equipamentos.*.quantidade' => 'required|integer|min:1',
            ]);

            $projeto->update($validatedData);

            $projetoData = $request->only(['nome', 'cliente_id', 'endereco_id', 'instalacao_id']);
            $projeto->update($projetoData);

            if($request->has('equipamentos')){
                $equipamentos = [];
                foreach ($request->equipamentos as $equipamento) {
                    $equipamentos[$equipamento['equipamento_id']] = ['quantidade' => $equipamento['quantidade']];
                }
    
                // Sincronizar os equipamentos com as quantidades na tabela intermediária
                $projeto->equipamentos()->sync($equipamentos);
            }

            return response()->json($projeto->load('equipamentos'), 200);
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
            $projeto = Projeto::findOrFail($id);
            $projeto->delete();
            return response()->json(['Projetos deletado com sucesso'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Projetos não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar o projeto: ' . $e->getMessage()], 500);
        }
    }
}

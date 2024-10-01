<?php

namespace App\Http\Controllers;

use App\Models\Instalacao;
use App\Services\InstalacaoServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class InstalacaoController extends Controller
{

    public $instalacaoServices;

    public function __construct(InstalacaoServices $instalacaoServices){
        $this->instalacaoServices = $instalacaoServices;
    }

    /**
     * @OA\Get(
     *     path="/api/instalacoes",
     *     summary="Listar todas as instalações",
     *     tags={"Instalações"},
     *     description="Retorna uma lista de todas as instalações.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de instalações",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Instalacao")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->instalacaoServices->buscaInstalacao(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/instalacoes",
     *     summary="Criar uma nova instalação",
     *     tags={"Instalações"},
     *     description="Cria uma nova instalação com os dados fornecidos.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"descricao"},
     *             @OA\Property(property="descricao", type="string", example="Instalação Fotovoltaica", description="Descrição da instalação")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Instalação criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Instalacao")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao criar instalação",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao criar instalação")
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

            $response = $this->instalacaoServices->criaInstalacao($validatedData);
            return response()->json($response, 201);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], status:500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/instalacoes/{id}",
     *     summary="Obter detalhes de uma instalação",
     *     tags={"Instalações"},
     *     description="Retorna os detalhes de uma instalação específica baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da instalação",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da instalação",
     *         @OA\JsonContent(ref="#/components/schemas/Instalacao")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Instalação não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Instalação não encontrada")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            return response()->json($this->instalacaoServices->buscaInstalacao($id), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/instalacoes/{id}",
     *     summary="Atualizar uma instalação",
     *     tags={"Instalações"},
     *     description="Atualiza os dados de uma instalação existente baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da instalação a ser atualizada",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"descricao"},
     *             @OA\Property(property="descricao", type="string", example="Instalação Atualizada", description="Descrição da instalação")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Instalação atualizada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Instalacao")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Instalação não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Instalação não encontrada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar instalação",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao atualizar instalação")
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

            return response()->json($this->instalacaoServices->editaInstalacao($validatedData, $id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Instalação não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar a instalação: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/instalacoes/{id}",
     *     summary="Deletar uma instalação",
     *     tags={"Instalações"},
     *     description="Deleta uma instalação existente baseado no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da instalação a ser deletada",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Instalação deletada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Instalação deletada com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Instalação não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Instalação não encontrada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar instalação",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao deletar instalação")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try{
            return response()->json($this->instalacaoServices->removerInstalacao($id),200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Instalação não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar a instalação: ' . $e->getMessage()], 500);
        }
    }
}

<?php

namespace Tests\Feature;

use App\Models\Projeto;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjetoControllerTest extends TestCase
{

    use RefreshDatabase;
    public function testIndexRetornaProjetos(): void
    {
        $projeto = Projeto::factory()->create([
            'id' => 1,
            'nome' => 'Projeto Teste',
        ]);

        $response = $this->getJson('/api/projetos');
        $response->assertStatus(200);
        $response->assertJson([
            [
                'id' => 1,
                'nome' => 'Projeto Teste',
                'cliente_id' => $projeto->cliente_id,
                'endereco_id' => $projeto->endereco_id,
                'instalacao_id' => $projeto->instalacao_id,
            ]
        ]);
    }

    public function testStoreFalhaValidacao()
    {
        $response = $this->postJson('/api/projetos', [
            'cliente_id' => 1,
            'endereco_id' => 1,
            'instalacao_id' => 1,
        ]);

        $response->assertStatus(status: 500);
    }

    public function testStoreRetornaSucesso()
    {
        Cliente::factory()->create(['id' => 1]);
        
        $data = [
            'nome' => 'Projeto Teste',
            'cliente_id' => 1,
            'endereco_id' => 1,
            'instalacao_id' => 1
        ];

        $response = $this->postJson('/api/projetos', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('projetos', [
            'nome' => 'Projeto Teste',
            'cliente_id' => 1,
            'endereco_id' => 1,
            'instalacao_id' => 1,
        ]);
    }

    public function testIndexNaoRetornaProjetoComNome(): void
    {
        Projeto::factory()->create([
            'id' => 1,
            'nome' => 'Projeto Teste'
        ]);

        $response = $this->getJson("/api/projetos?nome=raphael");

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    public function testShowRetorna404QuandoNaoAchaProjeto()
    {
        $response = $this->getJson('/api/projetos/999');

        $response->assertStatus(500);
        $response->assertJson([
            'error' => 'Projeto não encontrado.'
        ]);
    }

    public function testShowRetornaProjetotComId()
    {
        $projeto = Projeto::factory()->create(['nome' => 'Projeto Teste']);

        $response = $this->getJson("/api/projetos/{$projeto->id}");
        $response->assertStatus(200);
        $response->assertJson(
            [
                'id' => $projeto->id,
                'nome' => 'Projeto Teste',
                'cliente_id' => $projeto->cliente_id,
                'endereco_id' => $projeto->endereco_id,
                'instalacao_id' => $projeto->instalacao_id,
            ]
        );
    }

    public function testDestroyRemoveProjetoComSucesso()
    {
        $projeto = Projeto::factory()->create();
        $response = $this->deleteJson("/api/projetos/{$projeto->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Projeto deletado com sucesso',
        ]);

        $this->assertDatabaseMissing('projetos', [
            'id' => $projeto->id,
        ]);
    }

    public function testDestroyRetorna404QuandoNaoAchaProjeto()
    {
        $response = $this->deleteJson('/api/projetos/999');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Projeto não encontrado',
        ]);
    }

    public function testUpdateRetornaSucesso(){
        $projeto = Projeto::factory()->create();
        $dadosAtualizados = [
            'nome' => 'Teste atualizado',
        ];

        $response = $this->putJson("/api/projetos/{$projeto->id}", $dadosAtualizados);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projetos', [
            'id' => $projeto->id,
            'nome' => 'Teste atualizado',
        ]);
    }
}

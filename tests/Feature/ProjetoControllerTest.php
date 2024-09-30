<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
// use Request;
use Illuminate\Http\Request;
use Tests\TestCase;
use Mockery;
use Illuminate\Support\Facades\Validator;

class ProjetoControllerTest extends TestCase
{

    use RefreshDatabase;
    public function testIndexReturnsProjects(): void
    {
        \App\Models\Projeto::factory()->create([
            'id' => 1,
            'nome' => 'Projeto Teste'
        ]);

        $response = $this->getJson('/api/projetos');
        $response->assertStatus(200);
        $response->assertJson([
            [
                'id' => 1,
                'nome' => 'Projeto Teste',
                'equipamentos' => []
            ]
        ]);
    }

    public function testStoreValidationFails()
    {
        $response = $this->postJson('/api/projetos', [
            'cliente_id' => 1,
            'endereco_id' => 1,
            'instalacao_id' => 1,
        ]);

        $response->assertStatus(status: 500);
    }

    public function testStoreReturnsSucess()
    {
        \App\Models\Cliente::factory()->create(['id' => 1]);

        // Dados para criar o projeto
        $data = [
            'nome' => 'Projeto Teste',
            'cliente_id' => 1,
            'endereco_id' => 1,
            'instalacao_id' => 1,
            'equipamentos' => [
                ['equipamento_id' => 1, 'quantidade' => 2],
                ['equipamento_id' => 2, 'quantidade' => 3]
            ]
        ];


        // Simular a requisição POST para criar o projeto
        $response = $this->postJson('/api/projetos', $data);

        // Verificar se a resposta tem o status 201 (criado com sucesso)
        $response->assertStatus(201);

        // Verificar se o projeto foi criado com os dados corretos
        $this->assertDatabaseHas('projetos', [
            'nome' => 'Projeto Teste',
            'cliente_id' => 1,
            'endereco_id' => 1,
            'instalacao_id' => 1,
        ]);

        // Verificar se os equipamentos foram associados ao projeto corretamente
        $this->assertDatabaseHas('projetos_equipamentos', [
            'projeto_id' => 2,
            'equipamento_id' => 1,
            'quantidade' => 2,
        ]);

        $this->assertDatabaseHas('projetos_equipamentos', [
            'projeto_id' => 2,
            'equipamento_id' => 2,
            'quantidade' => 3,
        ]);
    }

    public function testIndexNotReturnProjectWithNome(): void
    {
        \App\Models\Projeto::factory()->create([
            'id' => 1,
            'nome' => 'Projeto Teste'
        ]);

        $response = $this->getJson('/api/projetos?nome=raphael');

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    public function testShowReturns404WhenProjetoNotFound()
    {
        $response = $this->getJson('/api/projetos/999');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Projeto não encontrado'
        ]);
    }

    public function testShowReturnsProjectWithId()
    {
        \App\Models\Projeto::factory()->create([
            'id' => 1,
            'nome' => 'Projeto Teste'
        ]);

        $response = $this->getJson('/api/projetos/1');
        $response->assertStatus(200);
        $response->assertJson(
            [
                'id' => 1,
                'nome' => 'Projeto Teste',
                'cliente_id' => 3,
                'endereco_id' => 1,
                'instalacao_id' => 1,
            ]
        );
    }
}

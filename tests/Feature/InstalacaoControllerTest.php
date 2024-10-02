<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Instalacao;
use Tests\TestCase;

class InstalacaoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexRetorna2Instalacao(): void
    {
        Instalacao::factory()->create();
        $response = $this->getJson('/api/instalacoes');
        $response->assertStatus(200);
    }

    public function testShowRetornaInstalacao()
    {
        $instalacao = Instalacao::factory()->create();
        $response = $this->getJson("/api/instalacoes/{$instalacao->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $instalacao->id,
            'descricao' => $instalacao->descricao,
        ]);
    }

    public function testShowNaoRetornaInstalacaoComId()
    {
        // Instalacao::factory()->create();
        $response = $this->getJson("/api/instalacoes/999");
        $response->assertStatus(404);
    }

    public function testStoreCriaInstalacao()
    {
        $dados = [
            'descricao' => 'Teste Instalação',
        ];

        $response = $this->postJson('/api/instalacoes', $dados);
        $response->assertStatus(201);
        $this->assertDatabaseHas('instalacoes', [
            'descricao' => 'Teste Instalação',
        ]);
    }

    public function testStoreFalhaCriaInstalacao()
    {
        $dados = [
        ];

        $response = $this->postJson('/api/instalacoes', $dados);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['descricao']);
    }

    public function testUpdateAtualizaInstalacao()
    {
        $instalacao = Instalacao::factory()->create();
        $dadosAtualizados = [
            'descricao' => 'Descrição atualizada',
        ];
        $response = $this->putJson("/api/instalacoes/{$instalacao->id}", $dadosAtualizados);
        $response->assertStatus(200);

        $this->assertDatabaseHas('instalacoes', [
            'id' => $instalacao->id,
            'descricao' => 'Descrição atualizada',
        ]);
    }

    public function testUpdateNaoAchaInstalacao()
    {
        Instalacao::factory()->create();
        $dadosAtualizados = [
            'descricao' => 'João Silva Atualizado',
        ];

        $response = $this->putJson("/api/instalacoes/99", $dadosAtualizados);
        $response->assertStatus(404);
        $response ->assertJson([
            "message" => "Instalação não encontrada"
        ]);
    }

    public function testUpdateFalhaValidacao(){
        $instalacao = Instalacao::factory()->create();
        $dadosInvalidos = [
            'descricao' => '',
        ];

        $response = $this->putJson("/api/instalacoes/{$instalacao->id}", $dadosInvalidos);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['descricao']);
    }

    public function testDestroyDeletaInstalacao()
    {
        $instalacao = Instalacao::factory()->create();
        $response = $this->deleteJson("/api/instalacoes/{$instalacao->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('instalacoes', [
            'id' => $instalacao->id,
        ]);
    }

    public function testDestroyNaoAchaInstalacao(){
        $response = $this->deleteJson('/api/instalacoes/999');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Instalação não encontrada',
        ]);
    }

    public function testShowComIdInvalido(){
        $response = $this->getJson('/api/instalacoes/abc');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'No query results for model [App\\Models\\Instalacao] abc',
        ]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Equipamento;
use Tests\TestCase;

class EquipamentoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexRetorna2Equipamento(): void
    {
        Equipamento::factory()->create();
        $response = $this->getJson('/api/equipamentos');
        $response->assertStatus(200);
    }

    public function testShowRetornaEquipamento()
    {
        $equipamento = Equipamento::factory()->create();
        $response = $this->getJson("/api/equipamentos/{$equipamento->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $equipamento->id,
            'descricao' => $equipamento->descricao,
        ]);
    }

    public function testShowNaoRetornaEquipamentoComId()
    {
        // Equipamento::factory()->create();
        $response = $this->getJson("/api/equipamentos/999");
        $response->assertStatus(404);
    }

    public function testStoreCriaEquipamento()
    {
        $dados = [
            'descricao' => 'Teste Instalação',
        ];

        $response = $this->postJson('/api/equipamentos', $dados);
        $response->assertStatus(201);
        $this->assertDatabaseHas('equipamentos', [
            'descricao' => 'Teste Instalação',
        ]);
    }

    public function testStoreFalhaCriaEquipamento()
    {
        $dados = [];

        $response = $this->postJson('/api/equipamentos', $dados);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['descricao']);
    }

    public function testUpdateAtualizaEquipamento()
    {
        $equipamento = Equipamento::factory()->create();
        $dadosAtualizados = [
            'descricao' => 'Descrição atualizada',
        ];
        $response = $this->putJson("/api/equipamentos/{$equipamento->id}", $dadosAtualizados);
        $response->assertStatus(200);

        $this->assertDatabaseHas('equipamentos', [
            'id' => $equipamento->id,
            'descricao' => 'Descrição atualizada',
        ]);
    }

    public function testUpdateNaoAchaEquipamento()
    {
        Equipamento::factory()->create();
        $dadosAtualizados = [
            'descricao' => 'João Silva Atualizado',
        ];

        $response = $this->putJson("/api/equipamentos/99", $dadosAtualizados);
        $response->assertStatus(404);
        $response ->assertJson([
            "message" => "Equipamento não encontrado"
        ]);
    }

    public function testDestroyDeletaEquipamento()
    {
        $equipamento = Equipamento::factory()->create();
        $response = $this->deleteJson("/api/equipamentos/{$equipamento->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('equipamentos', [
            'id' => $equipamento->id,
        ]);
    }

    public function testUpdateFalhaValidacao(){
        $equipamento = Equipamento::factory()->create();
        $dadosInvalidos = [
            'descricao' => '',
        ];

        $response = $this->putJson("/api/equipamentos/{$equipamento->id}", $dadosInvalidos);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['descricao']);
    }

    public function testDestroyNaoAchaEquipamento(){
        $response = $this->deleteJson('/api/equipamentos/999');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'equipamento não encontrado',
        ]);
    }

    public function testShowComIdInvalido(){
        $response = $this->getJson('/api/equipamentos/abc');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'No query results for model [App\\Models\\Equipamento] abc',
        ]);
    }

}

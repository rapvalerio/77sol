<?php

namespace Tests\Feature;

use App\Models\Projeto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ProjetoEquipamento;
use Tests\TestCase;

class ProjetoEquipamentoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexRetornaProjetoEquipamento(): void
    {
        ProjetoEquipamento::factory()->count(3)->create();
        $response = $this->getJson('/api/projetos-equipamentos');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function testShowRetornaProjetoEquipamento()
    {
        $projetoEquipamento = ProjetoEquipamento::factory()->create();
        $response = $this->getJson("/api/projetos-equipamentos/{$projetoEquipamento->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'projeto_id' => $projetoEquipamento->projeto_id,
            'equipamento_id' => $projetoEquipamento->equipamento_id,
            'quantidade' => $projetoEquipamento->quantidade,
        ]);
    }

    public function testShowNaoRetornaProjetoEquipamentoComId()
    {
        ProjetoEquipamento::factory()->create();
        $response = $this->getJson("/api/projetos-equipamentos/999");
        $response->assertStatus(404);
    }

    public function testStoreCriaProjetoEquipamento()
    {
        Projeto::factory()->create(['id' => 1]);
        $dados = [
            'projeto_id' => '1',
            'equipamento_id' => '1',
            'quantidade' => '10',
        ];

        $response = $this->postJson('/api/projetos-equipamentos', $dados);
        $response->assertStatus(201);
        $this->assertDatabaseHas('projetos_equipamentos', [
            'projeto_id' => '1',
            'equipamento_id' => '1',
            'quantidade' => '10',
        ]);
    }

    public function testStoreFalhaCriaProjetoEquipamento()
    {
        $dados = [
            'equipamento_id' => '1',
            'quantidade' => '10',
        ];

        $response = $this->postJson('/api/projetos-equipamentos', $dados);
        $response->assertStatus(500);
        $response->assertJson([
            'error' => "The projeto id field is required."
        ]);
    }

    public function testUpdateAtualizaProjetoEquipamento()
    {
        Projeto::factory()->create(['id' => 1]);
        $projetoEquipamento = ProjetoEquipamento::factory()->create();
        $dadosAtualizados = [
            'projeto_id' => '1',
            'equipamento_id' => '1',
            'quantidade' => '10',
        ];

        $response = $this->putJson("/api/projetos-equipamentos/{$projetoEquipamento->id}", $dadosAtualizados);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projetos_equipamentos', [
            'id' => $projetoEquipamento->id,
            'projeto_id' => '1',
            'equipamento_id' => '1',
            'quantidade' => '10',
        ]);
    }

    public function testUpdateNaoAchaProjetoEquipamento()
    {
        ProjetoEquipamento::factory()->create();
        $dadosAtualizados = [
            'quantidade' => '1',
        ];

        $response = $this->putJson("/api/projetos-equipamentos/99", $dadosAtualizados);
        $response->assertStatus(404);
        $response ->assertJson([
            "message" => "Equipamentos do projeto não encontrados"
        ]);
    }

    public function testDestroyDeletaProjetoEquipamento()
    {
        $projetoEquipamento = ProjetoEquipamento::factory()->create();
        $response = $this->deleteJson("/api/projetos-equipamentos/{$projetoEquipamento->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('projetos_equipamentos', [
            'id' => $projetoEquipamento->id,
        ]);
    }
}

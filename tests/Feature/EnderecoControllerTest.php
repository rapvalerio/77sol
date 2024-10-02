<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Endereco;
use Tests\TestCase;

class EnderecoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexRetornaTodosEndereco(): void
    {
        $response = $this->getJson('/api/enderecos');
        $response->assertStatus(200);
        $response->assertJsonCount(27);
    }

    public function testShowRetornaEndereco()
    {
        $endereco = Endereco::factory()->create(['uf' => 'CC']);
        $response = $this->getJson("/api/enderecos/{$endereco->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $endereco->id,
            'uf' => $endereco->uf,
        ]);
    }

    public function testShowNaoRetornaEnderecoComId()
    {
        $response = $this->getJson("/api/enderecos/999");
        $response->assertStatus(404);
    }

    public function testStoreCriaEndereco()
    {
        $dados = [
            'uf' => 'QW',
        ];

        $response = $this->postJson('/api/enderecos', $dados);
        $response->assertStatus(201);
        $this->assertDatabaseHas('enderecos', [
            'uf' => 'QW',
        ]);
    }

    public function testStoreFalhaCriaEndereco()
    {
        $dados = [];

        $response = $this->postJson('/api/enderecos', $dados);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['uf']);
    }

    public function testUpdateAtualizaEndereco()
    {
        $endereco = Endereco::first();
        $dadosAtualizados = [
            'uf' => 'VV',
        ];
        $response = $this->putJson("/api/enderecos/{$endereco->id}", $dadosAtualizados);
        $response->assertStatus(200);

        $this->assertDatabaseHas('enderecos', [
            'id' => $endereco->id,
            'uf' => 'VV',
        ]);
    }

    public function testUpdateNaoAchaEndereco()
    {
        $dadosAtualizados = [
            'uf' => 'ZZ',
        ];

        $response = $this->putJson("/api/enderecos/999", $dadosAtualizados);
        $response->assertStatus(404);
        $response ->assertJson([
            "message" => "Endereço não encontrado"
        ]);
    }

    public function testDestroyDeletaEndereco()
    {
        $endereco = Endereco::factory()->create(['uf' => 'TT']);
        $response = $this->deleteJson("/api/enderecos/{$endereco->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('enderecos', [
            'id' => $endereco->id,
        ]);
    }

    public function testUpdateFalhaValidacao(){
        $endereco = Endereco::factory()->create(['uf' => 'DD']);

        $dadosInvalidos = [
            'uf' => 'ABC',
        ];

        $response = $this->putJson("/api/enderecos/{$endereco->id}", $dadosInvalidos);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['uf']);
    }

    public function testDestroyNaoAchaEndereco(){
        $response = $this->deleteJson('/api/enderecos/999');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Endereço não encontrado',
        ]);
    }

    public function testShowComIdInvalido(){
        $response = $this->getJson('/api/enderecos/abc');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'No query results for model [App\\Models\\Endereco] abc',
        ]);
    }
}

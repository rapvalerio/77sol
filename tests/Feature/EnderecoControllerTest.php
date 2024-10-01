<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Endereco;
use Tests\TestCase;

class EnderecoControllerTest extends TestCase
{
    use RefreshDatabase;

    //TODO: Pensar em uma maneira de melhorar esse teste, as vezes ele tenta criar um estado que ja existe e acaba falahndo o teste
    public function testIndexRetorna2Endereco(): void
    {
        Endereco::factory()->create();
        $response = $this->getJson('/api/enderecos');
        $response->assertStatus(200);
    }

    public function testShowRetornaEndereco()
    {
        $endereco = Endereco::factory()->create();
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
        $dados = [
        ];

        $response = $this->postJson('/api/enderecos', $dados);
        $response->assertStatus(500);
        $response->assertJson([
            'error' => "The uf field is required."
        ]);
    }

    public function testUpdateAtualizaEndereco()
    {
        $endereco = Endereco::factory()->create();
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
        Endereco::factory()->create();
        $dadosAtualizados = [
            'descricao' => 'João Silva Atualizado',
        ];

        $response = $this->putJson("/api/enderecos/99", $dadosAtualizados);
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
}

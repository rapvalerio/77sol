<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Cliente;
use Tests\TestCase;

class ClienteControllerTest extends TestCase
{
    
    use RefreshDatabase;

    public function testIndexRetornaCliente(): void
    {
        Cliente::factory()->count(3)->create();
        $response = $this->getJson('/api/clientes');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function testShowRetornaCliente()
    {
        $cliente = Cliente::factory()->create();
        $response = $this->getJson("/api/clientes/{$cliente->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $cliente->id,
            'nome' => $cliente->nome,
            'email' => $cliente->email,
            'telefone' => $cliente->telefone,
            'documento' => $cliente->documento,
        ]);
    }

    public function testShowNaoRetornaClienteComId()
    {
        Cliente::factory()->create();
        $response = $this->getJson("/api/clientes/999");
        $response->assertStatus(404);
    }

    public function testStoreCriaCliente()
    {
        $dados = [
            'nome' => 'João Silva',
            'email' => 'joao@email.com',
            'telefone' => '11999999999',
            'documento' => '30528750003',
        ];

        $response = $this->postJson('/api/clientes', $dados);
        $response->assertStatus(201);
        $this->assertDatabaseHas('clientes', [
            'nome' => 'João Silva',
            'email' => 'joao@email.com',
            'telefone' => '11999999999',
            'documento' => '30528750003',
        ]);
    }

    public function testStoreFalhaCriaCliente()
    {
        $dados = [
            'email' => 'joao@email.com',
            'telefone' => '11999999999',
            'documento' => '30528750003',
        ];

        $response = $this->postJson('/api/clientes', $dados);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nome']);
    }

    public function testUpdateAtualizaCliente()
    {
        $cliente = Cliente::factory()->create();
        $dadosAtualizados = [
            'nome' => 'João Silva Atualizado',
            'email' => 'joaoatualizado@email.com',
            'telefone' => '11988888888',
            'documento' => '98765432100',
        ];

        $response = $this->putJson("/api/clientes/{$cliente->id}", $dadosAtualizados);

        $response->assertStatus(200);

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'nome' => 'João Silva Atualizado',
            'email' => 'joaoatualizado@email.com',
            'telefone' => '11988888888',
            'documento' => '98765432100',
        ]);
    }

    public function testUpdateNaoAchaCliente()
    {
        $cliente = Cliente::factory()->create();
        $dadosAtualizados = [
            'nome' => 'João Silva Atualizado',
            'email' => 'joaoatualizado@email.com',
            'telefone' => '11988888888',
            'documento' => '98765432100',
        ];

        $response = $this->putJson("/api/clientes/99", $dadosAtualizados);
        $response->assertStatus(404);
        $response ->assertJson([
            "message" => "Cliente não encontrado"
        ]);
    }

    public function testDestroyDeletaCliente()
    {
        $cliente = Cliente::factory()->create();
        $response = $this->deleteJson("/api/clientes/{$cliente->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('clientes', [
            'id' => $cliente->id,
        ]);
    }

    public function testStoreFalhaValidacaoEmailInvalido(){
        $dados = [
            'nome' => 'João Silva',
            'email' => 'email-invalido',
            'telefone' => '11999999999',
            'documento' => '22945267837',
        ];

        $response = $this->postJson('/api/clientes', $dados);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }
    public function testUpdateFalhaValidacao(){
        $cliente = Cliente::factory()->create();

        $dadosInvalidos = [
            'nome' => '',
            'email' => 'email-invalido',
            'telefone' => '11988888888',
            'documento' => 'documento-invalido',
        ];

        $response = $this->putJson("/api/clientes/{$cliente->id}", $dadosInvalidos);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nome', 'email', 'documento']);
    }

    public function testDestroyNaoAchaCliente(){
        $response = $this->deleteJson('/api/clientes/999');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Cliente não encontrado',
        ]);
    }

    public function testShowComIdInvalido(){
        $response = $this->getJson('/api/clientes/abc');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'No query results for model [App\\Models\\Cliente] abc',
        ]);
    }

}

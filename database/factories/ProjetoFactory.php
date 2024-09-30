<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Projeto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjetoFactory extends Factory
{
    protected $model = Projeto::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'cliente_id' => Cliente::factory(),
            'endereco_id' => 1,
            'instalacao_id' => 1,
        ];
    }
}

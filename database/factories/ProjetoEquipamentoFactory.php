<?php

namespace Database\Factories;

use App\Models\ProjetoEquipamento;
use App\Models\Projeto;
use App\Models\Equipamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjetoEquipamentoFactory extends Factory
{
    protected $model = ProjetoEquipamento::class;

    public function definition()
    {
        return [
            'projeto_id' => Projeto::factory(),
            'equipamento_id' => Equipamento::factory(),
            'quantidade' => $this->faker->numberBetween(1, 100),
        ];
    }
}

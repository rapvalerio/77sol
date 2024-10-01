<?php

namespace Database\Factories;

use App\Models\Equipamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipamentoFactory extends Factory
{
    protected $model = Equipamento::class;

    public function definition()
    {
        return [
            'descricao' => $this->faker->name,
        ];
    }
}

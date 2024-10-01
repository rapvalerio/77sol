<?php

namespace Database\Factories;

use App\Models\Instalacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstalacaoFactory extends Factory
{
    protected $model = Instalacao::class;

    public function definition()
    {
        return [
            'descricao' => $this->faker->name,
        ];
    }
}

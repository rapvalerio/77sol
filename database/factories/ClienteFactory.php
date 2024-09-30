<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'telefone' => $this->faker->phoneNumber,
            'documento' => $this->faker->numerify('###########')
        ];
    }
}

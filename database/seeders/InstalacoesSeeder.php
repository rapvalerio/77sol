<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstalacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instalacoes = [
            [
                'descricao' => 'Fibrocimento (Madeira)',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Fibrocimento (Metálico)',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Cerâmico',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Metálico',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Laje',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Solo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
    
        \App\Models\Instalacao::insert($instalacoes);
    }
}

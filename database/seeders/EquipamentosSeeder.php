<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipamentos = [
            [
                'descricao' => 'Módulo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Inversor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Microinversor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Estrutura',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Cabo vermelho',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Cabo preto',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'String Box',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Cabo Tronco',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'descricao' => 'Endcap',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
    
        \App\Models\Equipamento::insert($equipamentos);
    }
}

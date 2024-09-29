<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnderecosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            ['uf' => 'AC'],
            ['uf' => 'AL'],
            ['uf' => 'AM'],
            ['uf' => 'AP'],
            ['uf' => 'BA'],
            ['uf' => 'CE'],
            ['uf' => 'DF'],
            ['uf' => 'ES'],
            ['uf' => 'GO'],
            ['uf' => 'MA'],
            ['uf' => 'MG'],
            ['uf' => 'MS'],
            ['uf' => 'MT'],
            ['uf' => 'PA'],
            ['uf' => 'PB'],
            ['uf' => 'PE'],
            ['uf' => 'PI'],
            ['uf' => 'PR'],
            ['uf' => 'RJ'],
            ['uf' => 'RN'],
            ['uf' => 'RO'],
            ['uf' => 'RR'],
            ['uf' => 'RS'],
            ['uf' => 'SC'],
            ['uf' => 'SE'],
            ['uf' => 'SP'],
            ['uf' => 'TO'],
        ];

        DB::table('enderecos')->insert($estados);
    }
}

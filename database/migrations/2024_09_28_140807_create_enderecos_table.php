<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->char('uf', 2)->unique();
            $table->timestamps();
        });

        DB::table('enderecos')->insert([
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
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};

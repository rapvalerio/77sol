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
            ['uf' => 'AC', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'AL', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'AM', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'AP', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'BA', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'CE', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'DF', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'ES', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'GO', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'MA', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'MG', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'MS', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'MT', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'PA', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'PB', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'PE', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'PI', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'PR', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'RJ', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'RN', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'RO', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'RR', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'RS', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'SC', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'SE', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'SP', 'created_at' => now(), 'updated_at' => now()],
            ['uf' => 'TO', 'created_at' => now(), 'updated_at' => now()],
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

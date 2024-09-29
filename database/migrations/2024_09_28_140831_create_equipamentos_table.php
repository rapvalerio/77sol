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
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->timestamps();
        });

        DB::table('equipamentos')->insert([
            ['descricao' => 'Módulo', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Inversor', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Microinversor', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Estrutura', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Cabo vermelho', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Cabo preto', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'String Box', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Cabo Tronco', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Endcap', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};

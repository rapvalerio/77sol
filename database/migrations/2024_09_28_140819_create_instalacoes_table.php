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
        Schema::create('instalacoes', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 100);
            $table->timestamps();
        });

        DB::table('instalacoes')->insert([
            ['descricao' => 'Fibrocimento (Madeira)', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Fibrocimento (Metálico)', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Cerâmico', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Metálico', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Laje', 'created_at' => now(), 'updated_at' => now()],
            ['descricao' => 'Solo', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instalacoes');
    }
};

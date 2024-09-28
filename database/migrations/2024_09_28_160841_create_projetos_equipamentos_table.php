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
        Schema::create('projetos_equipamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->constrained('projetos')->onDelete('cascade');
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->integer('quantidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos_equipamentos');
    }
};

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
        Schema::create('ouvidoria', function (Blueprint $table) {
            $table->id();
            $table->timestamp("hora")->nullable();
            $table->string("nome")->nullable();
            $table->string("municipio")->nullable();
            $table->text("requerente")->nullable();
            $table->string("email")->nullable();
            $table->string("cpf")->nullable();
            $table->string("telefone")->nullable();
            $table->text("relato")->nullable();
            $table->string("protocolo")->nullable();
            $table->text("resolucao")->nullable();
            $table->string("status")->nullable();
            $table->string("dias")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ouvidoria');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissoesTable extends Migration
{
    public function up()
    {
        Schema::create('missoes', function (Blueprint $table) {
            $table->id();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->json('objetivos'); // Armazena objetivos e municípios selecionados
            $table->json('militares'); // Armazena dados dos militares
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('missoes');
    }
}
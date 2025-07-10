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
        $table->json('objetivos');
        $table->json('militares');
        $table->boolean('usar_itinerarios')->default(false);
        $table->json('itinerarios_por_objetivo')->nullable(); // Adicionado
        $table->string('status')->nullable();
        $table->text('observacao')->nullable();
        $table->timestamps();
    });
}
    public function down()
    {
        Schema::dropIfExists('missoes');
    }
}
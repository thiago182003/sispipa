<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('itinerarios', function (Blueprint $table) {
        $table->id();
        $table->integer('numero')->unique()->comment('Número sequencial do itinerário');
        $table->json('municipios')->comment('Array de municípios do itinerário');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerarios');
    }
};



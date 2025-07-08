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
        Schema::create('missoes_antigas', function (Blueprint $table) {
            $table->id();
            $table->string('MILITAR')->nullable();
            $table->string('POSTOGRAD')->nullable();
            $table->string('NOMEGUERRA')->nullable();
            $table->string('OM')->nullable();
            $table->date('DATA_IDA')->nullable();
            $table->date('DATA_RETORNO')->nullable();
            $table->string('MES')->nullable();
            $table->integer('NUM_MES')->nullable();
            $table->text('MISSAO')->nullable();
            $table->decimal('VALORES', 15, 2)->nullable();
            $table->decimal('QTD_DIARIAS', 10, 2)->nullable();
            $table->integer('ANO')->nullable();
            $table->string('META')->nullable();
            $table->string('EQUIPE')->nullable();
            $table->text('BOLETIM')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missoes_antigas');
    }
};

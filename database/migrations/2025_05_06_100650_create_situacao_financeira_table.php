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
        Schema::create('situacao_financeira', function (Blueprint $table) {
            $table->id();
            $table->string("ano",4);
            $table->tinyInteger("mes");
            $table->integer('pf_empenhado');
            $table->integer('pf_liquidado');
            $table->integer('pf_pago');
            $table->integer('pj_empenhado');
            $table->integer('pj_liquidado');
            $table->integer('pj_pago');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('situacao_financeira');
    }
};

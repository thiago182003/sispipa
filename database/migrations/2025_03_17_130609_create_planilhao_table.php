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
        Schema::create('planilhao', function (Blueprint $table) {
            $table->id();
            $table->string("UG");
            $table->string("NOME_UG");
            $table->string("ICFEX");
            $table->string("PROGRAMA");
            $table->string("NOME_PROGRAMA");
            $table->string("ACAO");
            $table->string("NOME_ACAO");
            $table->string("UGR");
            $table->string("NOME_UGR");
            $table->string("PTRES");
            $table->string("FONTE");
            $table->string("NOME_FONTE");
            $table->string("PI");
            $table->string("NOME_PI");
            $table->string("ND");
            $table->string("SI");
            $table->string("NE");
            $table->string("TIPOEMPENHO");
            $table->string("CHAVE");
            $table->string("EMISSAO");
            $table->string("FAV");
            $table->string("NOME_FAV");
            $table->string("COD_AMPARO");
            $table->string("MOD_LIC");
            $table->string("REF_DISP");
            $table->text("OBS");
            $table->string("LOCAL");
            $table->string("RP");
            $table->string("NOME_RP");
            $table->string("TIPO_CREDITO");
            $table->string("NOME_TIPO_CREDITO");
            $table->string("PO");
            $table->string("AUTOR_EMENDA");
            $table->string("NOME_AUTOR_EMENDA");
            $table->string("NOME_UO");
            $table->string("UO");
            $table->decimal("A_LIQUIDAR",10,2);
            $table->decimal("EM_LIQUIDACAO",10,2);
            $table->decimal("LIQUIDADO",10,2);
            $table->decimal("PAGO",10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planilhao');
    }
};

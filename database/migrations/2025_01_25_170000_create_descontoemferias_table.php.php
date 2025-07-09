<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescontoemferiasTable extends Migration
{
    public function up()
    {
        Schema::create('descontoemferias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('militar_id');
            $table->integer('qtd_dias');
            $table->string('diex_numero', 100);
            $table->string('diex_arquivo')->nullable();
            $table->string('anoreferencia', 4);
            $table->timestamps();

            $table->foreign('militar_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('descontoemferias');
    }
}
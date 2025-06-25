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
        Schema::create('import_missao', function (Blueprint $table) {
            $table->id();
            $table->string('militar')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('om')->nullable();
            $table->date('dataida')->nullable();
            $table->date('dataretorno')->nullable();
            $table->string('mes')->nullable();
            $table->string('ano')->nullable();
            $table->text('missao')->nullable();
            $table->string('valor')->nullable();
            $table->double('qtddiarias')->nullable();
            $table->integer('equipe')->nullable();
            $table->string('boletim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_missao');
    }
};

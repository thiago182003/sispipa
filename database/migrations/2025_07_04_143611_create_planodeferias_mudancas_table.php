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
        Schema::create('planodeferias_mudancas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planodeferias_id')->constrained('planodeferias')->onDelete('cascade');
            $table->string('diex');
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planodeferias_mudancas');
    }
};

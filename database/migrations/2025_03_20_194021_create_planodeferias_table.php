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
        Schema::create('planodeferias', function (Blueprint $table) {
            $table->id();
            $table->integer('qtdparcelas');
            $table->date('p1inicio')->nullable();
            $table->date('p1fim')->nullable();
            $table->date('p2inicio')->nullable();
            $table->date('p2fim')->nullable();
            $table->date('p3inicio')->nullable();
            $table->date('p3fim')->nullable();
            $table->foreignId('militar_id')->constrained('users')->onDelete('cascade');
            $table->integer('anoreferencia');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planodeferias');
    }
};

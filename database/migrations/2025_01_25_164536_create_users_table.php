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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nomeguerra');
            $table->string('cpf')->nullable()->unique();
            $table->string('identidade')->nullable();
            $table->string('identidade_emissor')->nullable();
            $table->string('identidade_data')->nullable();
            $table->string('identidade_militar')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->boolean('veterano')->nullable();
            $table->date('dtnascimento')->nullable();
            $table->date('dtpraca')->nullable();
            $table->foreignId('om_servico_id')->nullable()->constrained('oms')->onDelete('set null');
            $table->foreignId('om_vinculo_id')->nullable()->constrained('oms')->onDelete('set null');
            $table->foreignId('secao_id')->nullable()->constrained('secoes')->onDelete('set null');
            $table->foreignId('postograduacao_id')->nullable()->constrained('posto_graduacoes')->onDelete('set null');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('status')->nullable();
            $table->integer('level')->nullable();
            $table->string('img')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

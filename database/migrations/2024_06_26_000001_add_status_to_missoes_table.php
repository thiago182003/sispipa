<?php
// Nova migration: database/migrations/2024_06_26_000001_add_status_to_missoes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('missoes', function (Blueprint $table) {
            $table->string('status')->nullable();
            $table->text('observacao')->nullable();
        });
    }

    public function down()
    {
        Schema::table('missoes', function (Blueprint $table) {
            $table->dropColumn(['status', 'observacao']);
        });
    }
};
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
        Schema::table('lists', function (Blueprint $table) {
            // Esta é a nossa nova coluna "interruptor"
            // Por padrão (default), o RSVP virá ATIVADO (true)
            $table->boolean('rsvp_enabled')->default(true)->after('plano_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lists', function (Blueprint $table) {
            // Remove a coluna se precisarmos reverter
            $table->dropColumn('rsvp_enabled');
        });
    }
};

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
        Schema::create('lists', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link com o usuário
    $table->string('event_type');       // Casamento, Aniversário...
    $table->string('display_name');     // "João e Maria"
    $table->date('event_date');         // Data do evento
    $table->string('style');            // Tradicional, Moderno...
    $table->boolean('plano_pago')->default(false); // (Para a Fase 3)
    $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lists');
    }
};

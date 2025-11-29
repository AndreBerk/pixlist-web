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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // ===================================
            // A CORREÇÃO ESTÁ AQUI
            // Trocamos 'list_model_id' por 'list_id'
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade');
            // ===================================

            // Esta é a chave para o presente (opcional, pois podemos não linkar)
            $table->foreignId('gift_id')->nullable()->constrained('gifts')->onDelete('set null');

            $table->decimal('amount', 10, 2); // O valor que foi pago
            $table->string('guest_name')->nullable();
            $table->text('guest_message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

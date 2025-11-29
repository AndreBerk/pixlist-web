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
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();

            // A qual lista esta confirmação pertence?
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade');

            // Dados do convidado
            $table->string('guest_name'); // Nome do convidado principal
            $table->integer('adults')->default(1); // Quantos adultos (mínimo 1)
            $table->integer('children')->default(0); // Quantas crianças
            $table->string('contact')->nullable(); // Email ou Telefone (opcional)

            $table->timestamps(); // Para sabermos quando confirmou
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvps');
    }
};

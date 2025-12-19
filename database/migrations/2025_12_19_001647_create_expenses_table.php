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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            // Vincula ao evento (lista)
            $table->foreignId('list_id')->constrained()->onDelete('cascade');

            // Detalhes da Despesa
            $table->string('description'); // Ex: Buffet, Fotógrafo
            $table->string('category')->nullable(); // Ex: Alimentação, Decoração
            $table->string('payment_method')->nullable(); // Ex: pix, credit_card [JÁ INCLUÍDO]

            // Valores e Datas
            $table->decimal('amount', 10, 2); // Valor Total
            $table->decimal('amount_paid', 10, 2)->default(0); // Valor já pago
            $table->date('due_date')->nullable(); // Data de vencimento

            // Status
            $table->enum('status', ['pending', 'partial', 'paid'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};

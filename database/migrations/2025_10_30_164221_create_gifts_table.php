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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();

            // Esta é a chave estrangeira correta
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();

            // Esta é a coluna de imagem correta
            $table->string('image_url')->nullable();

            $table->decimal('value', 10, 2);
            $table->integer('quantity')->default(1);
            $table->integer('quantity_paid')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};

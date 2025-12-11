<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_photos', function (Blueprint $table) {
            $table->id();
            // Liga a foto à lista do evento
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade');

            $table->string('photo_path'); // O caminho do arquivo (ex: event_photos/foto1.jpg)
            $table->string('guest_name')->nullable(); // Quem enviou?
            $table->text('message')->nullable(); // Legenda opcional

            // Controle de Moderação (Padrão: false/pendente)
            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_photos');
    }
};

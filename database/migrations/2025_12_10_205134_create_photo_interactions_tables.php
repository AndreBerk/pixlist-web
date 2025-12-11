<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de Comentários
        Schema::create('photo_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_photo_id')->constrained()->onDelete('cascade');
            $table->string('author_name'); // Nome de quem comentou
            $table->text('content');       // O comentário
            $table->timestamps();
        });

        // Tabela de Likes
        Schema::create('photo_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_photo_id')->constrained()->onDelete('cascade');
            $table->string('session_id')->index(); // Identifica o usuário sem login
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_likes');
        Schema::dropIfExists('photo_comments');
    }
};

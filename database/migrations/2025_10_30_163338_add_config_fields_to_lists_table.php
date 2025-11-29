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
        // Adiciona as novas colunas à tabela 'lists'
        Schema::table('lists', function (Blueprint $table) {
            $table->decimal('meta_goal', 10, 2)->default(0)->after('style');
            $table->string('pix_key')->nullable()->after('meta_goal');
            $table->string('cover_photo_url')->nullable()->after('pix_key');
            $table->text('story')->nullable()->after('cover_photo_url');
            $table->string('event_location')->nullable()->after('story');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove as colunas se precisarmos reverter
        Schema::table('lists', function (Blueprint $table) {
            $table->dropColumn([
                'meta_goal',
                'pix_key',
                'cover_photo_url',
                'story',
                'event_location'
            ]);
        });
    }
};

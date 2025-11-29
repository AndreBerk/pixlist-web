<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Esta coluna vai controlar se o tutorial já foi visto
        // default(false) garante que todos os novos utilizadores vejam o tutorial
        $table->boolean('has_seen_dashboard_tutorial')->default(false)->after('remember_token');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('has_seen_dashboard_tutorial');
    });
}
};

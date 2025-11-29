<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
    Schema::table('transactions', function (Blueprint $table) {
        // 0 = Pendente, 1 = Aprovado
        $table->boolean('is_approved')->default(false)->after('guest_message');
    });
}
public function down(): void {
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn('is_approved');
    });
}
};

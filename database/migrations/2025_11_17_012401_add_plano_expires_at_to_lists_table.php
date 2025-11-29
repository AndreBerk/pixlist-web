<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
    Schema::table('lists', function (Blueprint $table) {
        // Guarda a data de expiração do plano PAGO
        $table->timestamp('plano_expires_at')->nullable()->after('trial_expires_at');
    });
}
public function down(): void {
    Schema::table('lists', function (Blueprint $table) {
        $table->dropColumn('plano_expires_at');
    });
}
};

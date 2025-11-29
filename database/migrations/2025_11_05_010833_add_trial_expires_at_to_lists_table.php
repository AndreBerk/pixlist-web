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
        Schema::table('lists', function (Blueprint $table) {
            // Esta coluna guarda a data/hora exata em que o teste termina
            // É 'nullable' porque, se o utilizador pagar, esta data não importa mais.
            $table->timestamp('trial_expires_at')->nullable()->after('rsvp_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lists', function (Blueprint $table) {
            $table->dropColumn('trial_expires_at');
        });
    }
};

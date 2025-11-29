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
        // O conteúdo foi comentado porque a coluna 'plano_pago' já existe.
        // Schema::table('lists', function (Blueprint $table) {
        //     $table->boolean('plano_pago')->default(false)->after('pix_key');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lists', function (Blueprint $table) {
            $table->dropColumn('plano_pago');
        });
    }
};

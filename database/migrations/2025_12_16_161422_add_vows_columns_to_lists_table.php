<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('lists', function (Blueprint $table) {
        $table->text('vows_bride')->nullable();      // Votos da Noiva
        $table->string('vows_bride_pin')->nullable(); // PIN da Noiva

        $table->text('vows_groom')->nullable();      // Votos do Noivo
        $table->string('vows_groom_pin')->nullable(); // PIN do Noivo
    });
}

public function down()
{
    Schema::table('lists', function (Blueprint $table) {
        $table->dropColumn(['vows_bride', 'vows_bride_pin', 'vows_groom', 'vows_groom_pin']);
    });
}
};

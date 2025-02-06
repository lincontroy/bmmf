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
        Schema::table('customer_stake_interests', function (Blueprint $table) {
            $table->string('currency_symbol', 30)->after('accept_currency_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_stake_interests', function (Blueprint $table) {
            $table->dropColumn('currency_symbol');
        });
    }
};

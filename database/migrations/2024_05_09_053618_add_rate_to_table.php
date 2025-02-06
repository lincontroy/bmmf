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
        Schema::table('accept_currencies', function (Blueprint $table) {
            $table->decimal('rate',16,6)->nullable()->after('symbol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accept_currencies', function (Blueprint $table) {
            $table->dropColumn('rate');
        });
    }
};

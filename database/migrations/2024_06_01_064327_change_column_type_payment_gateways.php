<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->decimal('min_deposit', 16, 2)->change();
            $table->decimal('max_deposit', 16, 2)->change();
            $table->decimal('fee_percent', 16, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->decimal('min_deposit', 9, 3)->change();
            $table->decimal('max_deposit', 9, 3)->change();
            $table->decimal('fee_percent', 9, 3)->change();
        });
    }
};

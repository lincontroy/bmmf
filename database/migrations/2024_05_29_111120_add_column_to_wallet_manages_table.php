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
        Schema::table('wallet_manages', function (Blueprint $table) {
            $table->decimal('received', 16, 6)->default(0)->comment('credit')->after('referral');
            $table->decimal('transfer', 16, 6)->default(0)->comment('debit')->after('investment');
            $table->decimal('transfer_fee', 16, 6)->default(0)->comment('debit')->after('withdraw_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_manages', function (Blueprint $table) {
            $table->dropColumn('received');
            $table->dropColumn('transfer');
            $table->dropColumn('transfer_fee');
        });
    }
};

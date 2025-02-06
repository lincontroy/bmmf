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
        Schema::table('merchant_customer_infos', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id'); // Add the UUID column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchant_customer_infos', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};

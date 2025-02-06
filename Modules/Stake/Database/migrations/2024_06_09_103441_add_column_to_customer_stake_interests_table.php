<?php

use App\Models\Customer;
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
            $table->foreignIdFor(Customer::class)->after('user_id')->constrained();
            $table->decimal('locked_amount', 16, 6)->after('accept_currency_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_stake_interests', function (Blueprint $table) {
            $table->dropColumn('customer_id');
            $table->dropColumn('locked_amount');
        });
    }
};

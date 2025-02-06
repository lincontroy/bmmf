<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('b2x_loan_repays', function (Blueprint $table) {
            $table->foreignIdFor(Customer::class)->nullable()->after('accept_currency_id')->constrained(); // Add new column
            $table->string('method')->nullable()->after('accept_currency_id'); // Add new column
            $table->decimal('fees', 16,6)->nullable()->after('accept_currency_id'); // Add new column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2x_loan_repays', function (Blueprint $table) {
            $table->dropColumn('method');
            $table->dropColumn('customer_id');
            $table->dropColumn('fees');
        });
    }
};

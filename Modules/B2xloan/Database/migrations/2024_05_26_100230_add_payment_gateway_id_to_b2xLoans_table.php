<?php

use App\Models\PaymentGateway;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('b2x_loans', function (Blueprint $table) {
            $table->foreignIdFor(PaymentGateway::class)->nullable()->after('b2x_loan_package_id')->constrained();
            $table->string('currency')->nullable()->after('b2x_loan_package_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2x_loans', function (Blueprint $table) {
            $table->dropColumn('payment_gateway_id');
            $table->dropColumn('currency');
        });
    }
};

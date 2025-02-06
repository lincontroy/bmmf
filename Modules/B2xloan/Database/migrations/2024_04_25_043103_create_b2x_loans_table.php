<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\B2xloan\App\Models\B2xLoanPackage;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('b2x_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(B2xLoanPackage::class)->constrained();
            $table->decimal('interest_percent', 16, 6);
            $table->decimal('loan_amount', 16, 2);
            $table->decimal('hold_btc_amount', 16, 6);
            $table->decimal('installment_amount', 16, 6);
            $table->integer('number_of_installment');
            $table->integer('paid_installment')->default(0);
            $table->integer('remaining_installment')->default(0);
            $table->enum('status', ['0', '1', '2', '3'])->default('2')->comment('0 = Rejected, 1 = Approved, 2 = Pending, 3 = Loan Closed');
            $table->string('checker_note')->nullable();
            $table->integer('checked_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2x_loans');
    }
};

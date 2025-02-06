<?php

use App\Enums\PaymentRequestEnum;
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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PaymentGateway::class)->constrained();
            $table->enum('txn_type', PaymentRequestEnum::toArray())->comment(
                '1 = Deposit, 2 = Withdraw, 3 = Merchant, 4 = Repayment'
            );
            $table->string('txn_token')->nullable();
            $table->string('currency', 30);
            $table->float('txn_amount', 16, 6);
            $table->float('usd_value', 16, 2);
            $table->float('fees', 16, 6);
            $table->string('user', 30)->nullable();
            $table->text('txn_data')->nullable();
            $table->enum('tx_status', ['0', '1', '2', '3'])->default('2')
                  ->comment('0 = Cancel, 1 = Success, 2 = Pending, 3 = Execute');
            $table->string('comment')->nullable();
            $table->string('ip_address', 30)->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};

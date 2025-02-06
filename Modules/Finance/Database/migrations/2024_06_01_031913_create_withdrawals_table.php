<?php

use App\Models\AcceptCurrency;
use App\Models\Customer;
use App\Models\PaymentGateway;
use App\Models\WithdrawalAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\App\Enums\WithdrawStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(PaymentGateway::class)->constrained();
            $table->foreignIdFor(AcceptCurrency::class)->constrained();
            $table->foreignIdFor(WithdrawalAccount::class)->constrained();
            $table->decimal('amount', 16, 6)->default(0);
            $table->decimal('fees', 16, 6);
            $table->string('request_ip')->nullable();
            $table->string('comments')->nullable();
            $table->integer('audited_by')->nullable();
            $table->enum('status', WithdrawStatusEnum::toArray())->default(2)->comment('1=Success, 2=Pending, 0=cancel');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};

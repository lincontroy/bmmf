<?php

use App\Models\PaymentGateway;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Merchant\App\Models\MerchantAcceptedCoin;
use Modules\Merchant\App\Models\MerchantAccount;
use Modules\Merchant\App\Models\MerchantCustomerInfo;
use Modules\Merchant\App\Models\MerchantPaymentTransaction;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('merchant_payment_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MerchantAccount::class)->constrained();
            $table->foreignIdFor(MerchantCustomerInfo::class)->constrained();
            $table->foreignIdFor(MerchantAcceptedCoin::class)->constrained();
            $table->foreignIdFor(PaymentGateway::class)->constrained();
            $table->foreignIdFor(MerchantPaymentTransaction::class)->constrained();
            $table->decimal('amount', 9,3);
            $table->decimal('received_amount', 9,3);
            $table->enum('status', ['3', '1', '2'])->default('3')->comment('1 = complete, 2 = pending, 3 = cancelled');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_payment_infos');
    }
};

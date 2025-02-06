<?php

use App\Models\AcceptCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Merchant\App\Models\MerchantPaymentUrl;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('merchant_accepted_coins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AcceptCurrency::class)->constrained();
            $table->foreignIdFor(MerchantPaymentUrl::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_accepted_coins');
    }
};

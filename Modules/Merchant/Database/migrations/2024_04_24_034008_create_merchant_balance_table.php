<?php

use App\Models\AcceptCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Merchant\App\Models\MerchantAccount;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('merchant_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AcceptCurrency::class)->constrained();
            $table->string('symbol')->nullable();
            $table->foreignIdFor(MerchantAccount::class)->constrained();
            $table->string('user_id')->nullable();
            $table->decimal('amount', 16, 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_balances');
    }
};

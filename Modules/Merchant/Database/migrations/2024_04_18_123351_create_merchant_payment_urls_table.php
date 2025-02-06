<?php

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
        Schema::create('merchant_payment_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MerchantAccount::class)->constrained();
            $table->string('uu_id');
            $table->string('title');
            $table->string('description');
            $table->enum('payment_type', ['0', '1'])->default('0')->comment('0 = Single, 1 = Multiple');
            $table->decimal('amount', 9,3);
            $table->string('calback_url');
            $table->string('message');
            $table->enum('status', ['0', '1'])->default('0')->comment('0 = Expired, 1 = Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_payment_urls');
    }
};

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
        Schema::create('merchant_customer_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MerchantAccount::class)->constrained();
            $table->string('email', 80)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_customer_infos');
    }
};

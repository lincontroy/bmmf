<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AcceptCurrency;
use App\Models\PaymentGateway;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accept_currency_gateways', function (Blueprint $table) {
            $table->foreignIdFor(AcceptCurrency::class)->constrained();
            $table->foreignIdFor(PaymentGateway::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accept_currency_gateways');
    }
};
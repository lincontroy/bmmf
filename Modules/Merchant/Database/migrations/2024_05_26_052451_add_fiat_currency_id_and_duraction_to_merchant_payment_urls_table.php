<?php

use App\Models\FiatCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('merchant_payment_urls', function (Blueprint $table) {
            $table->foreignIdFor(FiatCurrency::class)->nullable()->after('amount')->constrained();
            $table->timestamp('duration')->nullable()->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchant_payment_urls', function (Blueprint $table) {
            $table->dropConstrainedForeignId('fiat_currency_id');
            $table->dropColumn('duration');
        });
    }
};

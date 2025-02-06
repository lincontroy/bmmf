<?php

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
        Schema::create('quick_exchange_coins', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('symbol');
            $table->string('coin_name')->nullable();
            $table->double('reserve_balance', 19, 8);
            $table->double('market_rate', 16, 4);
            $table->tinyInteger('price_type')->default(0)->comment('0=Manual, 1=Automatic');
            $table->double('sell_adjust_price', 16, 4);
            $table->double('buy_adjust_price', 16, 4);
            $table->double('minimum_tx_amount', 16, 4);
            $table->string('wallet_id', 255);
            $table->integer('coin_position')->default(0);
            $table->string('url', 255);
            $table->tinyInteger('base_currency')->nullable()->comment('1=Base Currency,0= Not Base Currency');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_exchange_coins');
    }
};

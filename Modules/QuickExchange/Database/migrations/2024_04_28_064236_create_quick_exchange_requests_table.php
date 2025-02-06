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
        Schema::create('quick_exchange_requests', function (Blueprint $table) {
            $table->increments('request_id');
            $table->string('user_id', 12)->nullable();
            $table->string('sell_coin', 20);
            $table->double('sell_amount', 19, 8);
            $table->string('buy_coin', 20);
            $table->double('buy_amount', 19, 8);
            $table->string('user_send_hash', 70)->nullable();
            $table->string('admin_send_hash', 70)->nullable();
            $table->string('admin_payment_wallet', 255);
            $table->string('user_payment_wallet', 50);
            $table->string('document', 100);
            $table->tinyInteger('status')->default(1)->comment('1 = complete, 0 = pending');
            $table->tinyInteger('fiat_currency')->default(1)->comment('0=Not Fiat 1= Fiat');
            $table->tinyInteger('show_status')->default(1)->comment('0=Not Fiat 1= Fiat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_exchange_requests');
    }
};

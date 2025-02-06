<?php

use App\Models\AcceptCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Stake\App\Models\CustomerStake;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_stake_interests', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 15);
            $table->foreignIdFor(CustomerStake::class)->constrained();
            $table->foreignIdFor(AcceptCurrency::class)->constrained();
            $table->decimal('interest_amount', 16, 6);
            $table->enum('status', ['1', '2'])->default('1')->comment('1 = Received, 2 = Running');
            $table->datetime('redemption_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_stake_interests');
    }
};

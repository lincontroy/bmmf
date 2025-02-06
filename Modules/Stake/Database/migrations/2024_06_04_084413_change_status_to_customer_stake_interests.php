<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Stake\App\Enums\CustomerStakeInterestEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customer_stake_interests', function (Blueprint $table) {
            $table->enum('status', CustomerStakeInterestEnum::toArray())
                ->default(CustomerStakeInterestEnum::RUNNING->value)->comment('1 = Received, 2 = Running')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
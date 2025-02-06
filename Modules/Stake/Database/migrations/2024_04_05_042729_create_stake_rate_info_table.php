<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Stake\App\Models\StakePlan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stake_rate_info', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StakePlan::class)->constrained();
            $table->integer('duration')->nullable()->comment('Days');
            $table->decimal('rate', 16, 4)->nullable()->comment('Interest Rate(%)');
            $table->decimal('annual_rate', 16, 4)->nullable()->comment('Annual Interest Rate(%)');
            $table->decimal('min_amount', 16, 4)->nullable();
            $table->decimal('max_amount', 16, 4)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stake_rate_info');
    }
};
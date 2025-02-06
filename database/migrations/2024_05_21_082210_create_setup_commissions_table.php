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
        Schema::create('setup_commissions', function (Blueprint $table) {
            $table->id();
            $table->string('level_name', 255);
            $table->float('personal_invest');
            $table->float('total_invest');
            $table->float('team_bonus');
            $table->float('referral_bonus');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setup_commissions');
    }
};

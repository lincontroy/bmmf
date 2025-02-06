<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Package\App\Models\TeamBonus;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_bonus_details', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 16)->nullable();
            $table->foreignIdFor(TeamBonus::class)->nullable();
            $table->float('sponsor_commission', 11, 2)->default(0.00);
            $table->float('team_commission', 11, 2)->default(0.00);
            $table->string('level', 50)->nullable();
            $table->dateTime('last_update')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_bonus_details');
    }
};

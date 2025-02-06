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
        Schema::table('b2x_loans', function (Blueprint $table) {
            $table->enum('withdraw_status', ['0', '1', '2', '3'])->default('3')
                  ->comment('0 = Rejected/Cancel, 1 = Success, 2 = Pending, 3=not submit')
                  ->nullable()
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

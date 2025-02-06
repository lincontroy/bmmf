<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('b2x_loans', function (Blueprint $table) {
            $table->enum('withdraw_status', ['0', '1', '2'])->comment('0 = Rejected/Cancel, 1 = Success, 2 = Pending')
                ->nullable()->after('status');
            $table->string('withdraw_note')->nullable()->after('withdraw_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2x_loans', function (Blueprint $table) {

            $table->dropColumn('withdraw_status');
            $table->dropColumn('withdraw_note');

        });
    }
};

<?php

use App\Models\Investment;
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
        Schema::create('investment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Investment::class)->unique()->constrained();
            $table->string('user_id', 15);
            $table->integer('roi_time');
            $table->integer('invest_qty');
            $table->decimal('roi_amount_per_qty', 9, 4);
            $table->decimal('roi_amount', 9, 4);
            $table->integer('total_number_of_roi');
            $table->decimal('total_roi_amount', 16, 4);
            $table->integer('paid_number_of_roi');
            $table->decimal('paid_roi_amount', 16, 4);
            $table->enum('status', ['0', '1', '2'])->default('0')->comment('0 = Pause, 2 = running, 1 = complete');
            $table->dateTime('next_roi_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_details');
    }
};

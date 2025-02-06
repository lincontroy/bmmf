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
        Schema::create('investment_rois', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Investment::class)->constrained();
            $table->string('user_id', 15);
            $table->decimal('roi_amount', 16, 4);
            $table->dateTime('received_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_rois');
    }
};

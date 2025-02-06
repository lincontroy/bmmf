<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Package\App\Models\Package;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Package::class)->constrained();
            $table->string('user_id', 12);
            $table->decimal('invest_amount', 16, 4);
            $table->integer('invest_qty');
            $table->decimal('total_invest_amount', 16, 4);
            $table->enum('status', ['0', '1'])->default('1')->comment('0 = inactive, 1 = active');
            $table->dateTime('expiry_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};

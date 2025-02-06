<?php

use Modules\Package\App\Models\PlanTime;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PlanTime::class)->constrained();
            $table->string('name', 100);
            $table->enum('invest_type', ['1', '2'])->comment("1 = Range, 2 = Fixed");
            $table->decimal('min_price', 9, 3);
            $table->decimal('max_price', 9, 3)->nullable();
            $table->enum('interest_type', ['1', '2'])->comment("1 = Percent, 2 = Fixed");
            $table->decimal('interest', 9, 3);
            $table->enum('return_type', ['1', '2'])->comment("1 = Life time, 2 = Repeat");
            $table->integer('repeat_time')->nullable();
            $table->enum('capital_back', ['0', '1'])->comment("0 = No, 1 = Yes")->nullable();
            $table->enum('status', ['0', '1'])->default('1')->comment("0 = inactive, 1 = active");
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

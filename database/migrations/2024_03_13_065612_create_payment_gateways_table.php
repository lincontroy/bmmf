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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->decimal('min_deposit', 9, 3);
            $table->decimal('max_deposit', 9, 3);
            $table->decimal('fee_percent', 9, 3);
            $table->string('logo', 150)->nullable();
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
        Schema::dropIfExists('payment_gateways');
    }
};
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
        Schema::create('b2x_loan_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no_of_month');
            $table->decimal('interest_percent', 16, 6);
            $table->enum('status', ['0', '1'])->default('1')->comment('1=active, 0=inactive');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2x_loan_packages');
    }
};

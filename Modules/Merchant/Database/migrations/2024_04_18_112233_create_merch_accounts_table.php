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
        Schema::create('merchant_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 15)->index();
            $table->string('store_name', 100)->nullable();
            $table->string('about', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->enum('status', ['0', '1', '2', '3'])->default('0')->comment('0 = Rejected, 1 = Approved, 2 = Pending, 3 = Suspend');
            $table->string('checker_note', 255)->nullable();
            $table->unsignedBigInteger('checked_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_accounts');
    }
};

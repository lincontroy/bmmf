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
        Schema::create('accept_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('symbol', 15);
            $table->string('logo', 255)->nullable();
            $table->enum('status', ['0', '1'])->default('1')->comment('0 = Inactive, 1 = Active');
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
        Schema::dropIfExists('accept_currencies');
    }
};

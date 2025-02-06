<?php

use App\Enums\NotificationEnum;
use App\Models\Customer;
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->string('notification_type', 30)->nullable();
            $table->string('subject')->nullable();
            $table->mediumText('details')->nullable();
            $table->enum('status', NotificationEnum::toArray())->default('1')->comment('0 = Read, 1 = Unread');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

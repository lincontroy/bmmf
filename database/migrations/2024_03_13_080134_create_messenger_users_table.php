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
        Schema::create('messenger_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 12)->nullable();
            $table->string('user_name', 50);
            $table->string('user_email', 80);
            $table->enum('message_status', ['0', '1'])->default('1')->comment("1=unread, 0= read");
            $table->dateTime('msg_time');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messenger_users');
    }
};

<?php

use App\Models\MessengerUser;
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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MessengerUser::class)->constrained();
            $table->string('user_id', 12)->nullable();
            $table->string('msg_subject', 255)->nullable();
            $table->string('msg_body', 2000);
            $table->dateTime('msg_time');
            $table->enum('replay_status', ['0', '1'])->default('1')->comment("0=customer,1=admin");
            $table->enum('msg_status', ['0', '1'])->default('1')->comment("	1=unread,0=read");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};

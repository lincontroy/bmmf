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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 20)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('username', 100)->unique();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verification_token')->nullable();
            $table->string('password');
            $table->string('phone', 50)->unique();
            $table->rememberToken();
            $table->string('google2fa_secret')->nullable();
            $table->boolean('google2fa_enable')->default(false);
            $table->string('referral_user', 20)->nullable();
            $table->string('language', 50)->nullable();
            $table->string('country', 20)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger("status")->default(0)->comment("0=Deactivated account, 1=Activated account, 2=Pending account, 3=Suspend account");
            $table->tinyInteger("verified_status")->default(0)->comment("0= did not submit info, 1= verified, 2=Cancel, 3=processing");
            $table->ipAddress('visitor')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_logout')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

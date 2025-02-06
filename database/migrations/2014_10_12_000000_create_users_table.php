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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 70)->nullable();
            $table->string('last_name', 70)->nullable();
            $table->string('about', 255)->nullable();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('image', 100)->nullable();
            $table->datetime('last_login')->nullable();
            $table->datetime('last_logout')->nullable();
            $table->string('ip_address', 14)->nullable();
            $table->enum('status', ['0', '1', '2', '3'])->default('1')
                ->comment('0 = Inactive, 1 = Active, 2=Pending, 3=Suspend');
            $table->enum('is_admin', ['0', '1'])->default('0');
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
        Schema::dropIfExists('users');
    }
};

<?php

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
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->enum('verify_type', ['1', '2', '3', '4', '0'])
                ->comment('1=Transfer, 2= Withdraw, 3=Profile Update, 4= Login, 0= Others');
            $table->string('code', 6);
            $table->text('verify_data')->nullable();
            $table->enum('status', ['0', '1', '2'])->default('2')->comment('0= Canceled, 1= Used, 2= New');
            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};

<?php

use App\Models\AcceptCurrency;
use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(AcceptCurrency::class)->constrained();
            $table->string('user_id', 20)->nullable();
            $table->dateTime('date');
            $table->string('method', 50)->nullable();
            $table->decimal('amount', 9, 3);
            $table->decimal('fees', 9, 3)->default(0);
            $table->string('stripe_session_id')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('comments')->nullable();
            $table->string('deposit_ip')->nullable();
            $table->enum('status', ['0', '1', '2'])->default('0')->comment("0 = pending, 1 = confirm, 2 = canceled");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};

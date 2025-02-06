<?php

use App\Models\AcceptCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallet_transaction_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id', 15)->index();
            $table->foreignIdFor(AcceptCurrency::class)->constrained();
            $table->string('transaction', 15);
            $table->enum('transaction_type', ['debit', 'credit']);
            $table->decimal('amount', 16, 6)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transaction_logs');
    }
};

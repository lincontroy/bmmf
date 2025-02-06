<?php

use App\Models\AcceptCurrency;
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
        Schema::create('b2x_currencies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AcceptCurrency::class)->constrained();
            $table->decimal('price', 9, 3);
            $table->enum('status', ['0', '1'])->default('1')->comment('1=active, 0=inactive');
            $table->enum('default_coin', ['0', '1'])->default('0')->comment('1=Default Coin, 0=Coin');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2x_currencies');
    }
};

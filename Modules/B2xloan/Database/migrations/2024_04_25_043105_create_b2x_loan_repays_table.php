<?php

use App\Models\AcceptCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\B2xloan\App\Models\B2xLoan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('b2x_loan_repays', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(B2xLoan::class)->constrained();
            $table->foreignIdFor(AcceptCurrency::class)->constrained();
            $table->decimal('amount', 16, 6);
            $table->enum('status', ['0', '1'])->default('0')->comment('0 = Pending, 1 = Success');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2x_loan_repays');
    }
};

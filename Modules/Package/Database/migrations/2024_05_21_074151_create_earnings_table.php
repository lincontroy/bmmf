<?php

use App\Models\Customer;
use App\Models\Investment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Package\App\Models\Package;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 16);
            $table->foreignIdFor(Customer::class)->nullable();
            $table->string('earning_type', 80);
            $table->foreignIdFor(Package::class)->nullable();
            $table->foreignIdFor(Investment::class)->nullable();
            $table->date('date');
            $table->float('amount', 11, 2);
            $table->mediumText('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earnings');
    }
};

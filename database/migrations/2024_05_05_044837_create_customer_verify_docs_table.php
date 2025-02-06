<?php

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
        Schema::create('customer_verify_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->string('user_id', 15)->nullable();
            $table->string('verify_type', 30);
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->tinyInteger('gender')->comment('1 = male, 0 = female');
            $table->string('id_number');
            $table->string('document1');
            $table->string('document2');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_verify_docs');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('merchant_payment_urls', function (Blueprint $table) {
            $table->string('calback_url', 255)->nullable()->default(null)->change();
            $table->string('message', 255)->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_payment_urls', function (Blueprint $table) {
            $table->string('calback_url', 255)->nullable(false)->default('')->change();
            $table->string('message', 255)->nullable(false)->default('')->change();
        });
    }
};

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
        Schema::table('customer_verify_docs', function (Blueprint $table) {
            $table->string('country', 100)->after('gender');
            $table->string('state', 100)->nullable()->after('gender');
            $table->string('city', 100)->after('gender');
            $table->string('document_type', 100)->after('gender');
            $table->date('expire_date')->after('id_number');
            $table->string('document3', 255)->after('document2');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_verify_docs', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('document_type');
            $table->dropColumn('expire_date');
            $table->dropColumn('document3');
        });
    }
};

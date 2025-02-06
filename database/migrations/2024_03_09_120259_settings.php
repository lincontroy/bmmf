<?php

use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->text('description')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 18)->nullable();
            $table->string('logo', 150)->nullable();
            $table->string('logo_web', 150)->nullable();
            $table->string('favicon', 150)->nullable();
            $table->foreignIdFor(Language::class)->constrained();
            $table->string('site_align', 20)->nullable();
            $table->string('footer_text', 255)->nullable();
            $table->string('time_zone', 100)->nullable();
            $table->string('office_time', 200)->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

<?php

use App\Models\TeamMember;
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
        Schema::create('team_member_socials', function (Blueprint $table) {
            $table->foreignIdFor(TeamMember::class)->constrained();
            $table->string('name', 150);
            $table->string('icon', 100)->nullable();
            $table->string('url', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_member_socials');
    }
};

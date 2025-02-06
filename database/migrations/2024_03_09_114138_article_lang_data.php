<?php

use App\Models\Article;
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
        Schema::create('article_lang_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Article::class)->constrained();
            $table->foreignIdFor(Language::class)->constrained();
            $table->string('slug', 255)->nullable();
            $table->string('small_content', 255)->nullable();
            $table->text('large_content')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('id');
            $table->index('article_id');
            $table->index('language_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_lang_data');
    }
};

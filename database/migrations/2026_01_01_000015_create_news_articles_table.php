<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->text('content_ar');
            $table->text('content_en')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->foreignId('author_id')->nullable()->constrained('dashboard_users')->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
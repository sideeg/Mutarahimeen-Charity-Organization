<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->text('content_ar');
            $table->text('content_en')->nullable();
            $table->json('media_urls')->nullable();
            $table->text('admin_notes')->nullable();
            $table->date('published_date');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_updates');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->enum('media_type', ['image', 'video']);
            $table->string('url');
            $table->string('caption_ar')->nullable();
            $table->string('caption_en')->nullable();
            $table->boolean('is_cover')->default(false);
            $table->unsignedTinyInteger('display_order')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_media');
    }
};
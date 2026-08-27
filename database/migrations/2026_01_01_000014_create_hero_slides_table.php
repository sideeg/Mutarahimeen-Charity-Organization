<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('headline_ar');
            $table->string('headline_en')->nullable();
            $table->string('highlighted_text_ar')->nullable();
            $table->string('highlighted_text_en')->nullable();
            $table->text('subtext_ar')->nullable();
            $table->text('subtext_en')->nullable();
            $table->string('image_url')->nullable();
            $table->string('cta_label_ar')->nullable();
            $table->string('cta_label_en')->nullable();
            $table->string('cta_url')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
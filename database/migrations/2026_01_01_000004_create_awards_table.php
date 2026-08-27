<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->unsignedSmallInteger('year');
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('issuer_ar')->nullable();
            $table->string('issuer_en')->nullable();
            $table->string('image_url')->nullable();
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('awards');
    }
};
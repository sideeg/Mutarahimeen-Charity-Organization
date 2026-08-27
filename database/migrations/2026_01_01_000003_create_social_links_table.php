<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform_name');
            $table->string('url');
            $table->string('icon_name')->nullable();
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};

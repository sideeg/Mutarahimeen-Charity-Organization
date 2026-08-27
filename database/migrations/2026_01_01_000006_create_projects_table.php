<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('project_categories')->restrictOnDelete();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->text('short_description_ar')->nullable();
            $table->text('short_description_en')->nullable();
            $table->text('full_description_ar')->nullable();
            $table->text('full_description_en')->nullable();
            $table->enum('type', ['sustainable', 'seasonal', 'relief']);
            $table->enum('status', ['active', 'completed', 'paused'])->default('active');
            $table->decimal('target_amount', 18, 2)->nullable();
            $table->decimal('raised_amount', 18, 2)->default(0);
            $table->unsignedInteger('beneficiaries_count')->nullable();
            $table->string('location_ar')->nullable();
            $table->string('location_en')->nullable();
            $table->string('governorate')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
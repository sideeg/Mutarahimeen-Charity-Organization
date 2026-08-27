<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impact_stats', function (Blueprint $table) {
            $table->id();
            $table->string('label_ar');
            $table->string('label_en')->nullable();
            $table->string('number_value')->nullable();  
            $table->string('suffix')->nullable();        
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->enum('source_type', ['manual', 'auto_calculated'])->default('manual');
            $table->enum('calculation_key', [
                'total_beneficiaries',
                'total_projects_completed',
                'total_volunteers',
                'total_countries',
            ])->nullable();
            $table->string('icon_name')->nullable();
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impact_stats');
    }
};
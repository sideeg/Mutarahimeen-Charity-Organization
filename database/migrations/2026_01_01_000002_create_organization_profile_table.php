<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('about_text_ar');
            $table->text('about_text_en')->nullable();
            $table->text('vision_ar');
            $table->text('vision_en')->nullable();
            $table->text('mission_ar');
            $table->text('mission_en')->nullable();
            $table->text('marketing_message_ar')->nullable();
            $table->text('marketing_message_en')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->string('address_ar')->nullable();
            $table->string('address_en')->nullable();
            $table->string('logo_url')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_profiles');
    }
};
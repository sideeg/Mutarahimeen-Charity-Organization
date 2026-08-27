<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method_name_ar');
            $table->string('method_name_en');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->text('instructions_ar')->nullable();
            $table->text('instructions_en')->nullable();
            $table->string('icon_url')->nullable();
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
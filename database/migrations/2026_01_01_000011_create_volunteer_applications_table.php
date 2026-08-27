<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->enum('volunteer_type', ['professional', 'digital']);
            $table->string('specialization')->nullable();
            $table->text('message_or_skills');
            $table->enum('status', ['new', 'reviewed', 'contacted'])->default('new');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_applications');
    }
};

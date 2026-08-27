<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->string('donor_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('amount', 18, 2);
            $table->enum('payment_method', ['bankak', 'fawri', 'mycash', 'bank_transfer']);
            $table->enum('donation_type', ['one_time', 'recurring'])->default('one_time');
            $table->enum('status', ['pending', 'confirmed', 'failed'])->default('pending');
            $table->string('transaction_reference')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};

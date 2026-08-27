<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dashboard_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->enum('role', ['super_admin', 'content_editor', 'finance']);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('dashboard_users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_users');
    }
};

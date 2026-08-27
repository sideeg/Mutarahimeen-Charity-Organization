<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('volunteer_applications', function (Blueprint $table) {
            // Re-defines the ENUM options natively in Laravel 11/12 with 'new' as the default fallback
            $table->enum('status', ['new', 'accepted', 'rejected'])
                  ->default('new')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteer_applications', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->change();
        });
    }
};
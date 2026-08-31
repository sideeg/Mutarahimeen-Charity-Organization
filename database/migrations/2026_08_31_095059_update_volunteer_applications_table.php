<?php
// database/migrations/2026_01_02_000001_update_volunteer_applications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('volunteer_applications', function (Blueprint $table) {
            $table->dropColumn('volunteer_type');
            $table->string('residence_state')->nullable()->after('phone');
            $table->string('whatsapp')->nullable()->after('residence_state');
            $table->enum('member_type', ['member', 'volunteer'])
                ->default('volunteer')
                ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('volunteer_applications', function (Blueprint $table) {
            $table->enum('volunteer_type', ['professional', 'digital'])->default('professional');
            $table->dropColumn(['residence_state', 'whatsapp']);
            $table->dropColumn('member_type');
        });
    }
};
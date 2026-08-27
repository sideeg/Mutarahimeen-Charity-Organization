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
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->string('volunteer_image_url')->nullable()->after('about_image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->dropColumn('volunteer_image_url');
        });
    }
};
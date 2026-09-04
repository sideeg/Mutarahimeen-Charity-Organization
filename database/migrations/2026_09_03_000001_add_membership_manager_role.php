// database/migrations/2026_09_03_000001_add_membership_manager_role.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        DB::statement("ALTER TABLE dashboard_users MODIFY role ENUM('super_admin','content_editor','finance','membership_manager') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE dashboard_users MODIFY role ENUM('super_admin','content_editor','finance') NOT NULL");
    }
};
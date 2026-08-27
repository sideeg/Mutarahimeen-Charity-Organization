<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Super admin — seeded first so created_by FK can reference it
        $superAdminId = DB::table('dashboard_users')->insertGetId([
            'name'          => 'مدير النظام',
            'email'         => 'admin@motrahimeen.org',
            'password_hash' => Hash::make('Admin@2026!'),
            'role'          => 'super_admin',
            'is_active'     => true,
            'last_login'    => null,
            'created_by'    => null,
            'created_at'    => now(),
        ]);

        // Content editor
        DB::table('dashboard_users')->insert([
            'name'          => 'محرر المحتوى',
            'email'         => 'content@motrahimeen.org',
            'password_hash' => Hash::make('Content@2026!'),
            'role'          => 'content_editor',
            'is_active'     => true,
            'last_login'    => null,
            'created_by'    => $superAdminId,
            'created_at'    => now(),
        ]);

        // Finance user
        DB::table('dashboard_users')->insert([
            'name'          => 'مسؤول المالية',
            'email'         => 'finance@motrahimeen.org',
            'password_hash' => Hash::make('Finance@2026!'),
            'role'          => 'finance',
            'is_active'     => true,
            'last_login'    => null,
            'created_by'    => $superAdminId,
            'created_at'    => now(),
        ]);
    }
}
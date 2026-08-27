<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed order respects FK dependencies:
     *  1. dashboard_users (no deps)
     *  2. org identity tables (no deps)
     *  3. project_categories → projects → project_updates
     *  4. donations (depends on projects)
     *  5. remaining standalone tables
     */
    public function run(): void
    {
        // ── Identity ──────────────────────────────────────────────────────────
        $this->call(DashboardUsersSeeder::class);
        $this->call(OrganizationProfileSeeder::class);
        $this->call(SocialLinksSeeder::class);
        $this->call(AwardsSeeder::class);

        // ── Projects ──────────────────────────────────────────────────────────
        $this->call(ProjectCategoriesSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(ProjectUpdatesSeeder::class);

        // ── Donations & Payments ──────────────────────────────────────────────
        $this->call(PaymentMethodsSeeder::class);
        $this->call(DonationsSeeder::class);

        // ── Volunteers & Partners ─────────────────────────────────────────────
        // $this->call(VolunteerApplicationsSeeder::class);
        $this->call(PartnersSeeder::class);

        // ── Content & Settings ────────────────────────────────────────────────
        $this->call(ImpactStatsSeeder::class);
        $this->call(HeroSlidesSeeder::class);
        $this->call(NewsArticlesSeeder::class);
        $this->call(SiteSettingsSeeder::class);
    }
}

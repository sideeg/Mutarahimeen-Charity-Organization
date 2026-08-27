<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\OrganizationProfile;
use App\Models\SocialLink;
use App\Models\ImpactStat;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Safe check to set the Inertia root view on admin dashboard routes
        if (!app()->runningInConsole() && request()->is('admin*')) {
            \Inertia\Inertia::setRootView('admin');
        }

        // Global View Composer to safely share branding and stats data with the layout
        View::composer('layouts.app', function ($view) {
            $view->with([
                'org'         => OrganizationProfile::first() ?: new OrganizationProfile(),
                'socialLinks' => SocialLink::where('is_active', true)->orderBy('display_order')->get(),
                'footerStats' => ImpactStat::where('is_active', true)->orderBy('display_order')->limit(4)->get(),
            ]);
        });
    }
}
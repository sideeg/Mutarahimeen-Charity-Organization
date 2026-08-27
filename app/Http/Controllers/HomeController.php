<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\ImpactStat;
use App\Models\NewsArticle;
use App\Models\OrganizationProfile;
use App\Models\Partner;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\SocialLink;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(): View
    {
        $heroSlides = HeroSlide::currentlyVisible()->get();
        Log::info($heroSlides);
        $impactStats = ImpactStat::where('is_active', true)
            ->orderBy('display_order')
            ->get()
            ->map(function ($stat) {
                // Resolve auto-calculated stats at runtime
                if ($stat->source_type === 'auto_calculated') {
                    $stat->number_value = match ($stat->calculation_key) {
                        'total_beneficiaries'       => number_format(Project::sum('beneficiaries_count')),
                        'total_projects_completed'  => Project::where('status', 'completed')->count(),
                        'total_volunteers'          => \App\Models\VolunteerApplication::where('status', 'contacted')->count(),
                        'total_countries'           => 1, // extend as needed
                        default                     => $stat->number_value,
                    };
                }
                return $stat;
            });
        Log::info($impactStats);
        $featuredProjects = Project::with(['category', 'coverImage'])
            ->active()
            ->featured()
            ->orderBy('display_order')
            ->limit(4)
            ->get();
        Log::info($featuredProjects);
        // Fallback: show any 4 active if none are featured
        if ($featuredProjects->isEmpty()) {
            $featuredProjects = Project::with(['category', 'coverImage'])
                ->active()
                ->orderBy('display_order')
                ->limit(4)
                ->get();
        }

        $categories = ProjectCategory::where('is_active', true)
            ->orderBy('display_order')
            ->limit(4)
            ->get();
        Log::info($categories);
        $latestNews = NewsArticle::published()
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();
        Log::info("5");
        $partners = Partner::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        Log::info("6");
        $socialLinks = SocialLink::active()->get();
        Log::info("7");
        $org = OrganizationProfile::instance();
        Log::info("8");
        return view('pages.home', compact(
            'heroSlides',
            'impactStats',
            'featuredProjects',
            'categories',
            'latestNews',
            'partners',
            'socialLinks',
            'org',
        ));
    }
}

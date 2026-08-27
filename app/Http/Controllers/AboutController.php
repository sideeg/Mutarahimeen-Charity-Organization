<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\ImpactStat;
use App\Models\OrganizationProfile;
use App\Models\Partner;
use App\Models\Project;
use App\Models\SocialLink;
use App\Models\VolunteerApplication;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $org = OrganizationProfile::instance();

        $awards = Award::active()->get();

        $impactStats = ImpactStat::where('is_active', true)
            ->orderBy('display_order')
            ->get()
            ->map(function ($stat) {
                if ($stat->source_type === 'auto_calculated') {
                    $stat->number_value = match ($stat->calculation_key) {
                        'total_beneficiaries'      => number_format(Project::sum('beneficiaries_count')),
                        'total_projects_completed' => Project::where('status', 'completed')->count(),
                        'total_volunteers'         => VolunteerApplication::where('status', 'contacted')->count(),
                        'total_countries'          => 1,
                        default                    => $stat->number_value,
                    };
                }
                return $stat;
            });

        $partners    = Partner::where('is_active', true)->orderBy('display_order')->get();
        $socialLinks = SocialLink::active()->get();

        return view('pages.about', compact(
            'org',
            'awards',
            'impactStats',
            'partners',
            'socialLinks',
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\SocialLink;
use Illuminate\View\View;

class ProjectsController extends Controller
{
    /** Projects listing — filterable by category */
    public function index(): View
    {
        $categories = ProjectCategory::where('is_active', true)
            ->withCount(['projects' => fn ($q) => $q->active()])
            ->orderBy('display_order')
            ->get();

        $activeCategory = request('category');

        $projectsQuery = Project::with(['category', 'coverImage'])
            ->active()
            ->orderBy('display_order');

        if ($activeCategory) {
            $projectsQuery->whereHas('category', fn ($q) => $q->where('id', $activeCategory));
        }

        $projects = $projectsQuery->get();

        $org        = OrganizationProfile::instance();
        $socialLinks = SocialLink::active()->get();

        return view('pages.projects', compact(
            'categories',
            'projects',
            'activeCategory',
            'org',
            'socialLinks',
        ));
    }

    /** Single project detail */
    public function show(int $id): View
    {
        $project = Project::with(['category', 'media', 'updates'])
            ->active()
            ->findOrFail($id);

        // Related projects in same category (max 3)
        $related = Project::with(['category', 'coverImage'])
            ->active()
            ->where('category_id', $project->category_id)
            ->where('id', '!=', $project->id)
            ->limit(3)
            ->get();

        $org        = OrganizationProfile::instance();
        $socialLinks = SocialLink::active()->get();

        return view('pages.project-detail', compact(
            'project',
            'related',
            'org',
            'socialLinks',
        ));
    }
}

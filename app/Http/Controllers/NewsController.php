<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use App\Models\OrganizationProfile;
use App\Models\SocialLink;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $articles = NewsArticle::published()
            ->orderByDesc('published_at')
            ->paginate(9);

        $org        = OrganizationProfile::instance();
        $socialLinks = SocialLink::active()->get();

        return view('pages.news', compact('articles', 'org', 'socialLinks'));
    }

    public function show(string $slug): View
    {
        $article = NewsArticle::published()->where('slug', $slug)->firstOrFail();
        $related = NewsArticle::published()
            ->where('id', '!=', $article->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $org        = OrganizationProfile::instance();
        $socialLinks = SocialLink::active()->get();

        return view('pages.news-detail', compact('article', 'related', 'org', 'socialLinks'));
    }
}

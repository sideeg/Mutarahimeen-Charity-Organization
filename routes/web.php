<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\HomeController as DashHomeController;
use App\Http\Controllers\Dashboard\ProjectController as DashProjectController;
use App\Http\Controllers\Dashboard\DonationController as DashDonationController;

use App\Http\Controllers\LocaleController;

Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
// Admin Authentication
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.store');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Secured SPA Dashboard Area
Route::middleware(['dashboard.auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashHomeController::class, 'index'])->name('index');
    
    // Projects CRUD
    Route::get('/projects', [DashProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [DashProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [DashProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [DashProjectController::class, 'edit'])->name('projects.edit');
    Route::post('/projects/{project}', [DashProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [DashProjectController::class, 'destroy'])->name('projects.destroy');

   // Donations Management
    Route::get('/donations', [DashDonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create', [DashDonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DashDonationController::class, 'store'])->name('donations.store');
    Route::post('/donations/{donation}/status', [DashDonationController::class, 'updateStatus'])->name('donations.status');
    // Admin User CRUD (Restricted to super_admin)
    Route::get('/users', [App\Http\Controllers\Dashboard\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Dashboard\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Dashboard\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Dashboard\UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{user}', [App\Http\Controllers\Dashboard\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Dashboard\UserController::class, 'destroy'])->name('users.destroy');

    // Individual Media Deletion
    Route::delete('/media/{media}', [App\Http\Controllers\Dashboard\ProjectController::class, 'deleteMedia'])->name('projects.media.destroy');

    Route::post('/media/{media}/set-cover', [\App\Http\Controllers\Dashboard\ProjectController::class, 'setCover'])
    ->name('admin.media.setCover');
    // Project Categories CRUD (Accessible by: super_admin, content_editor)
    Route::get('/categories', [App\Http\Controllers\Dashboard\ProjectCategoryController::class, 'index']);
    Route::get('/categories/create', [App\Http\Controllers\Dashboard\ProjectCategoryController::class, 'create']);
    Route::post('/categories', [App\Http\Controllers\Dashboard\ProjectCategoryController::class, 'store']);
    Route::get('/categories/{category}/edit', [App\Http\Controllers\Dashboard\ProjectCategoryController::class, 'edit']);
    Route::post('/categories/{category}', [App\Http\Controllers\Dashboard\ProjectCategoryController::class, 'update']);
    Route::delete('/categories/{category}', [App\Http\Controllers\Dashboard\ProjectCategoryController::class, 'destroy']);

    // Project Updates CRUD (Accessible by: super_admin, content_editor)
    Route::get('/updates', [App\Http\Controllers\Dashboard\ProjectUpdateController::class, 'index']);
    Route::get('/updates/create', [App\Http\Controllers\Dashboard\ProjectUpdateController::class, 'create']);
    Route::post('/updates', [App\Http\Controllers\Dashboard\ProjectUpdateController::class, 'store']);
    Route::get('/updates/{update}/edit', [App\Http\Controllers\Dashboard\ProjectUpdateController::class, 'edit']);
    Route::post('/updates/{update}', [App\Http\Controllers\Dashboard\ProjectUpdateController::class, 'update']);
    Route::delete('/updates/{update}', [App\Http\Controllers\Dashboard\ProjectUpdateController::class, 'destroy']);

    // Hero Slides CRUD (Accessible by: super_admin, content_editor)
    Route::get('/hero-slides', [App\Http\Controllers\Dashboard\HeroSlideController::class, 'index']);
    Route::get('/hero-slides/create', [App\Http\Controllers\Dashboard\HeroSlideController::class, 'create']);
    Route::post('/hero-slides', [App\Http\Controllers\Dashboard\HeroSlideController::class, 'store']);
    Route::get('/hero-slides/{slide}/edit', [App\Http\Controllers\Dashboard\HeroSlideController::class, 'edit']);
    Route::post('/hero-slides/{slide}', [App\Http\Controllers\Dashboard\HeroSlideController::class, 'update']);
    Route::delete('/hero-slides/{slide}', [App\Http\Controllers\Dashboard\HeroSlideController::class, 'destroy']);

    // Impact Statistics CRUD (Accessible by: super_admin, content_editor)
    Route::get('/impact-stats', [App\Http\Controllers\Dashboard\ImpactStatController::class, 'index']);
    Route::get('/impact-stats/create', [App\Http\Controllers\Dashboard\ImpactStatController::class, 'create']);
    Route::post('/impact-stats', [App\Http\Controllers\Dashboard\ImpactStatController::class, 'store']);
    Route::get('/impact-stats/{stat}/edit', [App\Http\Controllers\Dashboard\ImpactStatController::class, 'edit']);
    Route::post('/impact-stats/{stat}', [App\Http\Controllers\Dashboard\ImpactStatController::class, 'update']);
    Route::delete('/impact-stats/{stat}', [App\Http\Controllers\Dashboard\ImpactStatController::class, 'destroy']);

    // News Articles CRUD (Accessible by: super_admin, content_editor)
    Route::get('/news', [App\Http\Controllers\Dashboard\NewsArticleController::class, 'index']);
    Route::get('/news/create', [App\Http\Controllers\Dashboard\NewsArticleController::class, 'create']);
    Route::post('/news', [App\Http\Controllers\Dashboard\NewsArticleController::class, 'store']);
    Route::get('/news/{article}/edit', [App\Http\Controllers\Dashboard\NewsArticleController::class, 'edit']);
    Route::post('/news/{article}', [App\Http\Controllers\Dashboard\NewsArticleController::class, 'update']);
    Route::delete('/news/{article}', [App\Http\Controllers\Dashboard\NewsArticleController::class, 'destroy']);
    
    // Organization Settings (Restricted to: super_admin)
    Route::get('/profile', [App\Http\Controllers\Dashboard\OrganizationProfileController::class, 'edit']);
    Route::post('/profile', [App\Http\Controllers\Dashboard\OrganizationProfileController::class, 'update']);

    // Partners CRUD (Accessible by: super_admin, content_editor)
    Route::get('/partners', [App\Http\Controllers\Dashboard\PartnerController::class, 'index']);
    Route::get('/partners/create', [App\Http\Controllers\Dashboard\PartnerController::class, 'create']);
    Route::post('/partners', [App\Http\Controllers\Dashboard\PartnerController::class, 'store']);
    Route::get('/partners/{partner}/edit', [App\Http\Controllers\Dashboard\PartnerController::class, 'edit']);
    Route::post('/partners/{partner}', [App\Http\Controllers\Dashboard\PartnerController::class, 'update']);
    Route::delete('/partners/{partner}', [App\Http\Controllers\Dashboard\PartnerController::class, 'destroy']);

    // Payment Methods CRUD (Accessible by: super_admin, finance)
    Route::get('/payment-methods', [App\Http\Controllers\Dashboard\PaymentMethodController::class, 'index']);
    Route::get('/payment-methods/create', [App\Http\Controllers\Dashboard\PaymentMethodController::class, 'create']);
    Route::post('/payment-methods', [App\Http\Controllers\Dashboard\PaymentMethodController::class, 'store']);
    Route::get('/payment-methods/{method}/edit', [App\Http\Controllers\Dashboard\PaymentMethodController::class, 'edit']);
    Route::post('/payment-methods/{method}', [App\Http\Controllers\Dashboard\PaymentMethodController::class, 'update']);
    Route::delete('/payment-methods/{method}', [App\Http\Controllers\Dashboard\PaymentMethodController::class, 'destroy']);

    // Site General Settings (Restricted to: super_admin)
    Route::get('/settings', [App\Http\Controllers\Dashboard\SiteSettingController::class, 'index']);
    Route::post('/settings/{setting}', [App\Http\Controllers\Dashboard\SiteSettingController::class, 'update']);

    // Social Links CRUD (Accessible by: super_admin, content_editor)
    Route::get('/social-links', [App\Http\Controllers\Dashboard\SocialLinkController::class, 'index']);
    Route::get('/social-links/create', [App\Http\Controllers\Dashboard\SocialLinkController::class, 'create']);
    Route::post('/social-links', [App\Http\Controllers\Dashboard\SocialLinkController::class, 'store']);
    Route::get('/social-links/{link}/edit', [App\Http\Controllers\Dashboard\SocialLinkController::class, 'edit']);
    Route::post('/social-links/{link}', [App\Http\Controllers\Dashboard\SocialLinkController::class, 'update']);
    Route::delete('/social-links/{link}', [App\Http\Controllers\Dashboard\SocialLinkController::class, 'destroy']);

    // Volunteer Applications (Accessible by: super_admin, content_editor)
    Route::get('/volunteers', [App\Http\Controllers\Dashboard\VolunteerApplicationController::class, 'index'])->name('volunteers.index');
    Route::get('/volunteers/create', [App\Http\Controllers\Dashboard\VolunteerApplicationController::class, 'create'])->name('volunteers.create');
    Route::post('/volunteers', [App\Http\Controllers\Dashboard\VolunteerApplicationController::class, 'store'])->name('volunteers.store');
    Route::post('/volunteers/{application}/status', [App\Http\Controllers\Dashboard\VolunteerApplicationController::class, 'updateStatus'])->name('volunteers.status');
    Route::delete('/volunteers/{application}', [App\Http\Controllers\Dashboard\VolunteerApplicationController::class, 'destroy'])->name('volunteers.destroy');
    Route::get('/volunteers/export', [App\Http\Controllers\Dashboard\VolunteerApplicationController::class, 'export'])->name('volunteers.export');
    Route::get('/volunteers/{application}/edit', [App\Http\Controllers\Dashboard\VolunteerApplicationController::class, 'edit']);
    Route::put('/volunteers/{application}', [App\Http\Controllers\Dashboard\VolunteerApplicationController::class, 'update']);
});


// ── Home ──────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── About ─────────────────────────────────────────────────────────────────
Route::get('/about', [AboutController::class, 'index'])->name('about');

// ── Projects ──────────────────────────────────────────────────────────────
Route::get('/projects',      [ProjectsController::class, 'index'])->name('projects');
Route::get('/projects/{id}', [ProjectsController::class, 'show'])->name('projects.show');

// ── Donate & Volunteer ────────────────────────────────────────────────────
Route::get('/donate',    [DonationController::class, 'index'])         ->name('donate');
Route::post('/donate',   [DonationController::class, 'store'])         ->name('donate.store');
Route::post('/volunteer',[DonationController::class, 'volunteerStore'])->name('volunteer.store');

// ── News ──────────────────────────────────────────────────────────────────
Route::get('/news',      [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}',[NewsController::class, 'show'])->name('news.show');

// ── Newsletter ────────────────────────────────────────────────────────────
Route::post('/newsletter/subscribe', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    \App\Models\NewsletterSubscriber::firstOrCreate(['email' => $request->email]);
    return back()->with('newsletter_success', true);
})->name('newsletter.subscribe');

// ── Contact Us Routes ────────────────────────────────────────────────────────────

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

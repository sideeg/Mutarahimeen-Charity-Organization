# منظمة متراحمين الخيرية — Mutrahimeen Charity Platform

A full-stack Laravel application for **Mutrahimeen Charity Organization**: a public bilingual (Arabic/English) website plus a role-based admin dashboard for managing projects, donations, volunteers, news, and site content.

-   **Public site:** Laravel Blade + Tailwind CDN + Alpine.js — server-rendered, RTL-aware, no build step required.
-   **Admin dashboard:** Laravel + Inertia.js + Vue 3 (`/admin/*`) — SPA-style, built with Vite.

---

## 📦 Tech Stack

| Layer           | Technology                                                                  |
| --------------- | --------------------------------------------------------------------------- |
| Backend         | Laravel (PHP), session-based custom admin auth (not Laravel Breeze/Fortify) |
| Public frontend | Blade, Tailwind (CDN), Alpine.js, Lucide icons (SVG, via JS)                |
| Admin frontend  | Vue 3 + Inertia.js, Tailwind, lucide-vue-next                               |
| Database        | MySQL/MariaDB (via Eloquent)                                                |
| Mail            | SMTP, configurable at runtime from the dashboard (writes to `.env`)         |
| Build tool      | Vite                                                                        |

---

## 🗂️ Project Structure

```
app/
├── Http/Controllers/            # Public site controllers (Home, About, Projects, Donation, Contact, News, Locale)
│   └── Dashboard/                # Admin dashboard controllers, one per resource
├── Http/Middleware/
│   ├── DashboardAuth.php         # Guards /admin/* routes via session('dashboard_user_id')
│   └── SetLocale.php             # Reads session('locale'), defaults to 'ar'
├── Models/                       # Eloquent models — most expose locale-aware accessors
│                                  # (getTitleAttribute() etc. fall back AR → EN)
└── Providers/AppServiceProvider.php
                                   # Sets Inertia root view to admin.blade.php on /admin*
                                   # Shares $org / $socialLinks / $footerStats globally to layouts.app

database/
├── migrations/                   # Schema, in chronological order
├── factories/                    # Model factories for seeding/testing
└── seeders/                      # Seed data (org profile, projects, categories, etc.)

resources/
├── views/
│   ├── layouts/app.blade.php     # Public site shell: nav, footer, theme, icon bootstrapping
│   ├── components/social-icon.blade.php
│   │                              # Renders brand icons via Simple Icons CDN (Lucide has no logos)
│   ├── emails/new-article.blade.php
│   ├── pages/*.blade.php         # home, about, projects, project-detail, donate, contact, news, news-detail
│   ├── admin.blade.php           # Inertia root view for the dashboard
│   └── app.blade.php             # Inertia root view (legacy/shared)
└── js/
    ├── app.js                    # Inertia + Vue bootstrap
    ├── Layouts/AuthenticatedLayout.vue
    └── Pages/                    # One folder per admin resource (Index.vue + Form.vue)

public/
├── icons/linkedin.svg            # Self-hosted fallback (Simple Icons dropped LinkedIn)
└── fonts/remixicon.css           # Legacy icon font, largely unused — public views now use Lucide
```

---

## 🚀 Getting Started

```bash
# 1. Install PHP deps
composer install

# 2. Install JS deps
npm install

# 3. Environment
cp .env.example .env
php artisan key:generate
# set DB_* and MAIL_* in .env

# 4. Database
php artisan migrate
php artisan db:seed

# 5. Storage symlink (for uploaded project/news/partner images)
php artisan storage:link

# 6. Run
php artisan serve         # backend
npm run dev                # Vite dev server (admin dashboard assets)
```

Public site: `http://localhost:8000`
Admin dashboard: `http://localhost:8000/admin`

---

## 🔑 Roles & Access

Auth is **custom**, not Laravel's built-in guard — `DashboardUser` records live in their own table, and the current user is tracked via `session('dashboard_user_id')` (set in `Dashboard/AuthController::login`), checked by `DashboardAuth` middleware.

| Role             | Access                                                                                                     |
| ---------------- | ---------------------------------------------------------------------------------------------------------- |
| `super_admin`    | Everything — org profile, site settings/SMTP, users, all resources below                                   |
| `content_editor` | Hero slides, social links, partners, news, impact stats, volunteers, projects, categories, project updates |
| `finance`        | Payment methods, donations                                                                                 |

Each `Dashboard/*Controller` enforces this itself via a private `authorizeX()` / `validateX()` helper called at the top of every action — **there's no route-level policy layer**, so a new admin controller must remember to call its own guard.

Login also requires a simple math **CAPTCHA** (`AuthController::generateCaptcha`), stored in session and checked on submit.

---

## 🌐 Public Site (Blade)

Routes (typical — see `routes/web.php` for exact names) map to:

| Page                                  | Controller           | View                                     |
| ------------------------------------- | -------------------- | ---------------------------------------- |
| `/`                                   | `HomeController`     | `pages.home`                             |
| `/about`                              | `AboutController`    | `pages.about`                            |
| `/projects`, `/projects/{id}`         | `ProjectsController` | `pages.projects`, `pages.project-detail` |
| `/donate` (+ `POST` donate/volunteer) | `DonationController` | `pages.donate`                           |
| `/contact` (+ `POST`)                 | `ContactController`  | `pages.contact`                          |
| `/news`, `/news/{slug}`               | `NewsController`     | `pages.news`, `pages.news-detail`        |
| `/locale/{locale}`                    | `LocaleController`   | redirects back, sets session locale      |

**Localization:** `SetLocale` middleware reads `session('locale')`, default `ar`. Models expose computed attributes like `getTitleAttribute()` that pick `_en` fields when locale is `en` and non-empty, else fall back to `_ar`. Toggle in the nav calls `route('locale.switch', ...)`.

**Theme:** Tailwind config lives inline in `layouts/app.blade.php` — a custom `rahma` palette (green / gold / sky-blue) matching the org logo, plus `rahma-gradient` / `rahma-gold-gradient` background utilities, a Cairo/Tajawal font stack, and full RTL support via `dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"`.

**Icons:** Rendered via [Lucide](https://lucide.dev) as real inline SVG (`<i data-lucide="name">`, converted client-side by `lucide.createIcons()`), **not** an icon font. Brand/social logos (Facebook, WhatsApp, LinkedIn, etc.) are **not** in Lucide's set — those go through the `<x-social-icon>` Blade component, which pulls from the Simple Icons CDN and falls back to a self-hosted SVG for LinkedIn (Simple Icons removed it).

Alpine.js is deliberately **not** auto-started — `window.deferLoadingAlpine` delays `Alpine.start()` until after `lucide.createIcons()` has run, so Alpine directives (`x-show`, `:class`, etc.) that sit on icon elements survive the icon-font→SVG conversion instead of being wiped out.

---

## 🛠️ Admin Dashboard (Inertia + Vue)

Entry point: `resources/js/app.js` resolves pages from `resources/js/Pages/**/*.vue` by component name (e.g. `Projects/Index`, `Volunteers/Form`).

Layout: `Layouts/AuthenticatedLayout.vue` — sidebar nav is conditionally rendered per `$page.props.auth.user.role`, with a matching mobile drawer.

Each resource typically has:

-   `Index.vue` — table/grid list + delete
-   `Form.vue` — shared create/edit form, `useForm()` posts to the resource's `store`/`update` route

Resources: Categories, Donations, HeroSlides, ImpactStats, News, Partners, PaymentMethods, Profile (org), Projects, Settings (site/SMTP), SocialLinks, Updates (project field reports), Users (dashboard admins), Volunteers.

**File uploads** go through `Storage::disk('public')->store(...)`, saved as `/storage/...` URLs — remember to run `php artisan storage:link` locally and on deploy.

**Site Settings → SMTP:** `SiteSettingController::update` writes mail keys directly into the server's `.env` file (`writeToEnv()`) and runs `config:clear` + `queue:restart` so changes take effect without a redeploy. This mutates the filesystem at runtime — be careful with file permissions and concurrent writes in production.

---

## ✉️ Newsletter / Email

`NewsArticleController::sendNotificationToSubscribers()` fires **synchronously** (no queue) whenever a news article is created/updated with `status = published`: it loops over all active `NewsletterSubscriber` rows, sends `emails.new-article`, and logs each send to `sent_emails`. On a large subscriber list this will block the publishing request — worth moving to a queued job (`ShouldQueue`) if the list grows.

---

## 🗃️ Database Notes

-   Most lookup/content tables (`ImpactStat`, `HeroSlide`, `Award`, etc.) have `$timestamps = false` and use `$guarded = ['id']` — be deliberate with mass-assignment from admin forms.
-   `Project.raised_amount` is **not** automatically kept in sync with `donations` except through the explicit increment/decrement logic in `Dashboard/DonationController` when a donation's `status` transitions to/from `confirmed` — direct DB edits to `donations.amount` or `status` will desync project totals.
-   `ImpactStat.source_type = 'auto_calculated'` stats are resolved at request time in `HomeController`/`AboutController` via a `match()` on `calculation_key` (`total_beneficiaries`, `total_projects_completed`, `total_volunteers`, `total_countries`) — adding a new auto-calculated stat means updating that `match()` in **both** controllers.
-   `SiteSetting::get()` is cached for 1 hour (`Cache::remember`) and flushed on save via a model `booted()` hook.

Seed data reflects the real organization (name, mission, socials, and its actual program areas: medical convoys, Ramadan baskets, Qurbani meat distribution, winter clothing, meal distribution, training programs, fixed-income projects) — see `database/seeders/` for details. A few values are intentionally left as placeholders (phone number, SMTP credentials, awards) pending real data from the org.

---

## ⚠️ Known Rough Edges

-   Debug `Log::info(...)` calls left in `HomeController@index` and `NewsArticleController` — safe to remove once the flows are trusted in production.
-   No centralized authorization layer for the dashboard; each controller re-implements its own role check — a missed `authorizeX()` call on a new controller means unrestricted access.
-   Newsletter sends are synchronous — consider queueing (`ShouldQueue` + `php artisan queue:work`) before the subscriber list grows large.
-   `.env` is written to directly from the Settings page — ensure the web server user has write access to it in production, and that this endpoint stays behind `super_admin` only.

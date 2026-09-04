<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Donation;
use App\Models\VolunteerApplication;
use App\Models\NewsletterSubscriber;
use App\Models\SentEmail;
use App\Models\DashboardUser;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private function authorizeAccess()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'finance'])) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة النظرة العامة.');
        }
    }

    public function index()
    {
        $this->authorizeAccess();

        $stats = [
            'total_raised'            => (float) Donation::where('status', 'confirmed')->sum('amount'),
            'pending_donations_count' => Donation::where('status', 'pending')->count(),
            'active_projects'         => Project::where('status', 'active')->count(),
            'volunteer_applications'  => VolunteerApplication::count(),
            'total_subscribers'       => NewsletterSubscriber::where('is_active', true)->count(),
            'emails_sent_today'       => SentEmail::whereDate('created_at', now()->today())->count(),
            'total_emails_sent'       => SentEmail::count(),
        ];

        $recent_donations = Donation::with('project:id,title_ar')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $monthly_performance = Donation::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(amount) as total")
        )
            ->where('status', 'confirmed')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        return inertia('Index', [
            'stats' => $stats,
            'recentDonations' => $recent_donations,
            'monthlyPerformance' => $monthly_performance,
        ]);
    }
}
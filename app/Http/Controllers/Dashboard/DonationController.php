<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Project;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    private function validateFinanceAccess()
    {
        $user = \App\Models\DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'finance'])) {
            abort(403, 'غير مصرح لك بإدارة أو تصفح الموقف المالي والتبرعات.');
        }
    }

    public function index()
    {
        $this->validateFinanceAccess();
        $donations = Donation::with('project:id,title_ar')
            ->orderByDesc('created_at')
            ->paginate(20);

        return inertia('Donations/Index', ['donations' => $donations]);
    }

    /** Render the Manual Donation Registration Form */
    public function create()
    {
        $this->validateFinanceAccess();
        
        $projects = Project::where('is_active', true)->get(['id', 'title_ar']);

        return inertia('Donations/Form', [
            'projects' => $projects
        ]);
    }

    /** Store manually registered transactions */
    public function store(Request $request)
    {
        $this->validateFinanceAccess();

        $validated = $request->validate([
            'donor_name'            => 'nullable|string|max:120',
            'email'                 => 'nullable|email|max:180',
            'phone'                 => 'nullable|string|max:30',
            'amount'                => 'required|numeric|min:1',
            'payment_method'        => 'required|in:bankak,fawri,mycash,bank_transfer',
            'donation_type'         => 'required|in:one_time,recurring',
            'project_id'            => 'nullable|exists:projects,id',
            'transaction_reference' => 'nullable|string|max:120',
            'status'                => 'required|in:pending,confirmed,failed',
            'admin_notes'           => 'nullable|string',
        ], [
            'amount.required'         => 'مبلغ التبرع مطلوب.',
            'amount.numeric'          => 'يجب أن يكون مبلغ التبرع قيمة رقمية صحيحة.',
            'amount.min'              => 'يجب أن يكون مبلغ التبرع 1 ج.س على الأقل.',
            'payment_method.required' => 'يرجى تحديد طريقة الدفع.',
            'donation_type.required'  => 'يرجى تحديد نوع التبرع.',
            'status.required'         => 'يرجى تحديد حالة التبرع الحالية.',
        ]);

        $donation = Donation::create($validated);

        // Auto-increment project's raised_amount if the manual transaction is confirmed immediately
        if ($donation->status === 'confirmed' && $donation->project_id) {
            $donation->project()->increment('raised_amount', $donation->amount);
        }

        return redirect()->route('admin.donations.index')->with('success', 'تم تسجيل وإيداع التبرع يدوياً بنجاح');
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        $this->validateFinanceAccess();
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,failed',
            'admin_notes' => 'nullable|string',
        ]);

        $oldStatus = $donation->status;
        $donation->update($validated);

        // Auto-increment project's raised_amount when a donation is confirmed
        if ($donation->status === 'confirmed' && $oldStatus !== 'confirmed' && $donation->project_id) {
            $donation->project()->increment('raised_amount', $donation->amount);
        }
        // Deduct if a confirmed status is reverted
        elseif ($oldStatus === 'confirmed' && $donation->status !== 'confirmed' && $donation->project_id) {
            $donation->project()->decrement('raised_amount', $donation->amount);
        }

        return back()->with('success', 'تم تحديث حالة التبرع والقيود المرتبطة بنجاح');
    }
}
<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\VolunteerApplication;
use App\Models\DashboardUser;
use Illuminate\Http\Request;

class VolunteerApplicationController extends Controller
{
    private function authorizeEditor()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor'])) {
            abort(403, 'غير مصرح لك بمراجعة أو إدارة طلبات المتطوعين.');
        }
    }

    public function index()
    {
        $this->authorizeEditor();
        $applications = VolunteerApplication::orderByDesc('id')->get();
        return inertia('Volunteers/Index', ['applications' => $applications]);
    }

    /** Display the Volunteer Creation Form */
    public function create()
    {
        $this->authorizeEditor();
        return inertia('Volunteers/Form', ['application' => null]);
    }

    /** Store a manually added Volunteer record */
    public function store(Request $request)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'full_name'         => 'required|string|max:120',
            'email'             => 'required|email|max:180',
            'phone'             => 'required|string|max:30',
            'volunteer_type'    => 'required|in:professional,digital',
            'specialization'    => 'nullable|string|max:120',
            'message_or_skills' => 'required|string|max:1000',
            'status'            => 'required|in:new,accepted,rejected',
        ], [
            'full_name.required'         => 'الاسم الكامل مطلوب.',
            'email.required'             => 'البريد الإلكتروني مطلوب.',
            'phone.required'             => 'رقم الهاتف مطلوب.',
            'message_or_skills.required' => 'يرجى كتابة المهارات أو كيفية المساهمة.',
        ]);

        VolunteerApplication::create($validated);

        return redirect('/admin/volunteers')->with('success', 'تم إضافة المتطوع يدوياً بنجاح');
    }

    public function updateStatus(Request $request, VolunteerApplication $application)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'status' => 'required|in:new,accepted,rejected',
        ]);

        $application->update($validated);

        return back()->with('success', 'تم تحديث حالة طلب التطوع بنجاح');
    }

    public function destroy(VolunteerApplication $application)
    {
        $this->authorizeEditor();
        $application->delete();
        return redirect('/admin/volunteers')->with('success', 'تم حذف طلب التطوع بنجاح');
    }
}
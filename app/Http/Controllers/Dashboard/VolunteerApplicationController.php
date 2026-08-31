<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\VolunteerApplication;
use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function create()
    {
        $this->authorizeEditor();
        return inertia('Volunteers/Form', ['application' => null]);
    }

    public function store(Request $request)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'full_name'         => 'required|string|max:120',
            'email'             => 'required|email|max:180',
            'phone'             => 'required|string|max:30',
            'whatsapp'          => 'required|string|max:30',
            'residence_state'   => 'required|string|max:100',
            'specialization'    => 'nullable|string|max:120',
            'message_or_skills' => 'required|string|max:1000',
            'status'            => 'required|in:new,accepted,rejected',
        ], [
            'full_name.required'         => 'الاسم الكامل مطلوب.',
            'email.required'             => 'البريد الإلكتروني مطلوب.',
            'phone.required'             => 'رقم الهاتف مطلوب.',
            'whatsapp.required'          => 'رقم الواتساب مطلوب.',
            'residence_state.required'   => 'مكان الإقامة مطلوب.',
            'message_or_skills.required' => 'يرجى كتابة الخبرة والأعمال الإنسانية السابقة.',
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

    /** Export all volunteer applications as an Excel-openable CSV file */
    public function export(): StreamedResponse
    {
        $this->authorizeEditor();

        $applications = VolunteerApplication::orderByDesc('id')->get();

        $filename = 'volunteer_applications_' . now()->format('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'الاسم الكامل',
            'البريد الإلكتروني',
            'الهاتف',
            'الواتساب',
            'مكان الإقامة',
            'التخصص',
            'الخبرة والأعمال الإنسانية السابقة',
            'الحالة',
            'تاريخ التسجيل',
        ];

        $callback = function () use ($applications, $columns) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM so Excel renders Arabic correctly
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->full_name,
                    $app->email,
                    $app->phone,
                    $app->whatsapp,
                    $app->residence_state,
                    $app->specialization,
                    $app->message_or_skills,
                    match ($app->status) {
                        'new' => 'جديد',
                        'accepted' => 'مقبول',
                        'rejected' => 'مرفوض',
                        default => $app->status,
                    },
                    $app->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}
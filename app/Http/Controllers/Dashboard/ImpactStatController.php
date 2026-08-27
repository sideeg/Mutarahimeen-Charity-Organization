<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ImpactStat;
use App\Models\DashboardUser;
use Illuminate\Http\Request;

class ImpactStatController extends Controller
{
    private function authorizeEditor()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor'])) {
            abort(403, 'غير مصرح لك بالوصول لإحصائيات الأثر.');
        }
    }

    public function index()
    {
        $this->authorizeEditor();
        $stats = ImpactStat::orderBy('display_order')->get();
        return inertia('ImpactStats/Index', ['stats' => $stats]);
    }

    public function create()
    {
        $this->authorizeEditor();
        return inertia('ImpactStats/Form', ['stat' => null]);
    }

    public function store(Request $request)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'label_ar' => 'required|string|max:255',
            'label_en' => 'nullable|string|max:255',
            'number_value' => 'required|numeric',
            'suffix' => 'nullable|string|max:50',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'source_type' => 'required|in:manual,calculated',
            'calculation_key' => 'nullable|string|max:100',
            'icon_name' => 'nullable|string|max:100',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        ImpactStat::create($validated);

        return redirect('/admin/impact-stats')->with('success', 'تم إضافة مؤشر الأثر بنجاح');
    }

    public function edit(ImpactStat $stat)
    {
        $this->authorizeEditor();
        return inertia('ImpactStats/Form', ['stat' => $stat]);
    }

    public function update(Request $request, ImpactStat $stat)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'label_ar' => 'required|string|max:255',
            'label_en' => 'nullable|string|max:255',
            'number_value' => 'required|numeric',
            'suffix' => 'nullable|string|max:50',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'source_type' => 'required|in:manual,calculated',
            'calculation_key' => 'nullable|string|max:100',
            'icon_name' => 'nullable|string|max:100',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $stat->update($validated);

        return redirect('/admin/impact-stats')->with('success', 'تم تحديث مؤشر الأثر بنجاح');
    }

    public function destroy(ImpactStat $stat)
    {
        $this->authorizeEditor();
        $stat->delete();
        return redirect('/admin/impact-stats')->with('success', 'تم حذف مؤشر الأثر بنجاح');
    }
}
<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    private function authorizeEditor()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor'])) {
            abort(403, 'غير مصرح لك بإدارة قائمة الشركاء.');
        }
    }

    public function index()
    {
        $this->authorizeEditor();
        $partners = Partner::orderBy('display_order')->get();
        return inertia('Partners/Index', ['partners' => $partners]);
    }

    public function create()
    {
        $this->authorizeEditor();
        return inertia('Partners/Form', ['partner' => null]);
    }

    public function store(Request $request)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'website_url' => 'nullable|string',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
            'logo_file' => 'required|image|max:2048',
        ]);

        $path = $request->file('logo_file')->store('partners', 'public');

        Partner::create(array_merge($validated, [
            'logo_url' => '/storage/' . $path,
        ]));

        return redirect('/admin/partners')->with('success', 'تم حفظ الشريك بنجاح');
    }

    public function edit(Partner $partner)
    {
        $this->authorizeEditor();
        return inertia('Partners/Form', ['partner' => $partner]);
    }

    public function update(Request $request, Partner $partner)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'website_url' => 'nullable|string',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
            'logo_file' => 'nullable|image|max:2048',
        ]);

        $updateData = $validated;

        if ($request->hasFile('logo_file')) {
            $oldPath = str_replace('/storage/', '', $partner->logo_url);
            Storage::disk('public')->delete($oldPath);

            $path = $request->file('logo_file')->store('partners', 'public');
            $updateData['logo_url'] = '/storage/' . $path;
        }

        $partner->update($updateData);

        return redirect('/admin/partners')->with('success', 'تم تحديث بيانات الشريك بنجاح');
    }

    public function destroy(Partner $partner)
    {
        $this->authorizeEditor();

        $filePath = str_replace('/storage/', '', $partner->logo_url);
        Storage::disk('public')->delete($filePath);

        $partner->delete();
        return redirect('/admin/partners')->with('success', 'تم حذف الشريك بنجاح');
    }
}
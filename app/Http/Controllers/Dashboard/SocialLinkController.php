<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use App\Models\DashboardUser;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    private function authorizeEditor()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor'])) {
            abort(403, 'غير مصرح لك بإدارة قنوات التواصل الاجتماعي.');
        }
    }

    public function index()
    {
        $this->authorizeEditor();
        $links = SocialLink::orderBy('display_order')->get();
        return inertia('SocialLinks/Index', ['links' => $links]);
    }

    public function create()
    {
        $this->authorizeEditor();
        return inertia('SocialLinks/Form', ['link' => null]);
    }

    public function store(Request $request)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'platform_name' => 'required|string|max:100',
            'url' => 'required|string',
            'icon_name' => 'nullable|string|max:100',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        SocialLink::create($validated);

        return redirect('/admin/social-links')->with('success', 'تم إضافة القناة بنجاح');
    }

    public function edit(SocialLink $link)
    {
        $this->authorizeEditor();
        return inertia('SocialLinks/Form', ['link' => $link]);
    }

    public function update(Request $request, SocialLink $link)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'platform_name' => 'required|string|max:100',
            'url' => 'required|string',
            'icon_name' => 'nullable|string|max:100',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $link->update($validated);

        return redirect('/admin/social-links')->with('success', 'تم تحديث القناة بنجاح');
    }

    public function destroy(SocialLink $link)
    {
        $this->authorizeEditor();
        $link->delete();
        return redirect('/admin/social-links')->with('success', 'تم حذف القناة بنجاح');
    }
}
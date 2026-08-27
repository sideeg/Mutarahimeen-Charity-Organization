<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationProfileController extends Controller
{
    private function authorizeAdmin()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || $user->role !== 'super_admin') {
            abort(403, 'غير مصرح لك بتعديل الملف والبيانات العامة للمنظمة.');
        }
    }

    public function edit()
    {
        $this->authorizeAdmin();
        $profile = OrganizationProfile::first() ?: new OrganizationProfile();
        return inertia('Profile/Form', ['profile' => $profile]);
    }

    public function update(Request $request)
    {
        $this->authorizeAdmin();

        $profile = OrganizationProfile::first() ?: new OrganizationProfile();

        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'about_text_ar' => 'nullable|string',
            'about_text_en' => 'nullable|string',
            'vision_ar' => 'nullable|string',
            'vision_en' => 'nullable|string',
            'mission_ar' => 'nullable|string',
            'mission_en' => 'nullable|string',
            'marketing_message_ar' => 'nullable|string',
            'marketing_message_en' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp_link' => 'nullable|string|max:255',
            'address_ar' => 'nullable|string',
            'address_en' => 'nullable|string',
            'logo_file' => 'nullable|image|max:2048',
            'about_image_file' => 'nullable|image|max:3072',
            'volunteer_image_file' => 'nullable|image|max:3072',
        ]);

        $updateData = $validated;

        if ($request->hasFile('logo_file')) {
            if ($profile->logo_url) {
                $oldPath = str_replace('/storage/', '', $profile->logo_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('logo_file')->store('profile', 'public');
            $updateData['logo_url'] = '/storage/' . $path;
        }

        if ($request->hasFile('about_image_file')) {
            if ($profile->about_image_url) {
                $oldPath = str_replace('/storage/', '', $profile->about_image_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('about_image_file')->store('profile', 'public');
            $updateData['about_image_url'] = '/storage/' . $path;
        }

        if ($request->hasFile('volunteer_image_file')) {
            if ($profile->volunteer_image_url) {
                $oldPath = str_replace('/storage/', '', $profile->volunteer_image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('volunteer_image_file')->store('profile', 'public');
            $updateData['volunteer_image_url'] = '/storage/' . $path;
        }

        unset($updateData['logo_file']);
        unset($updateData['about_image_file']);
        unset($updateData['volunteer_image_file']);

        if ($profile->exists) {
            $profile->update($updateData);
        } else {
            OrganizationProfile::create($updateData);
        }

        return redirect('/admin/profile')->with('success', 'تم حفظ بيانات ملف المنظمة بنجاح');
    }
}
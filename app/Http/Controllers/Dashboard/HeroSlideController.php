<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    private function authorizeEditor()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor'])) {
            abort(403, 'غير مصرح لك بالوصول لقسم لافتات البداية.');
        }
    }

    public function index()
    {
        $this->authorizeEditor();
        $slides = HeroSlide::orderBy('display_order')->get();
        return inertia('HeroSlides/Index', ['slides' => $slides]);
    }

    public function create()
    {
        $this->authorizeEditor();
        return inertia('HeroSlides/Form', ['slide' => null]);
    }

    public function store(Request $request)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'headline_ar' => 'required|string|max:255',
            'headline_en' => 'nullable|string|max:255',
            'highlighted_text_ar' => 'nullable|string|max:255',
            'highlighted_text_en' => 'nullable|string|max:255',
            'subtext_ar' => 'nullable|string',
            'subtext_en' => 'nullable|string',
            'cta_label_ar' => 'nullable|string|max:100',
            'cta_label_en' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
            'image_file' => 'required|image|max:3072',
        ]);

        $path = $request->file('image_file')->store('slides', 'public');

        HeroSlide::create(array_merge($validated, [
            'image_url' => '/storage/' . $path,
        ]));

        return redirect('/admin/hero-slides')->with('success', 'تم إضافة لافتة البداية بنجاح');
    }

    public function edit(HeroSlide $slide)
    {
        $this->authorizeEditor();
        return inertia('HeroSlides/Form', ['slide' => $slide]);
    }

    public function update(Request $request, HeroSlide $slide)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'headline_ar' => 'required|string|max:255',
            'headline_en' => 'nullable|string|max:255',
            'highlighted_text_ar' => 'nullable|string|max:255',
            'highlighted_text_en' => 'nullable|string|max:255',
            'subtext_ar' => 'nullable|string',
            'subtext_en' => 'nullable|string',
            'cta_label_ar' => 'nullable|string|max:100',
            'cta_label_en' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
            'image_file' => 'nullable|image|max:3072',
        ]);

        $updateData = $validated;

        if ($request->hasFile('image_file')) {
            $oldPath = str_replace('/storage/', '', $slide->image_url);
            Storage::disk('public')->delete($oldPath);

            $path = $request->file('image_file')->store('slides', 'public');
            $updateData['image_url'] = '/storage/' . $path;
        }

        $slide->update($updateData);

        return redirect('/admin/hero-slides')->with('success', 'تم تحديث اللافتة بنجاح');
    }

    public function destroy(HeroSlide $slide)
    {
        $this->authorizeEditor();

        $filePath = str_replace('/storage/', '', $slide->image_url);
        Storage::disk('public')->delete($filePath);

        $slide->delete();
        return redirect('/admin/hero-slides')->with('success', 'تم حذف لافتة البداية بنجاح');
    }
}
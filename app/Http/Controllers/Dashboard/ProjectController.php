<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    private function checkWriteAccess()
    {
        $user = \App\Models\DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor'])) {
            abort(403, 'غير مصرح لك بإجراء تعديلات على المشاريع.');
        }
    }

    public function index()
    {
        $projects = Project::with('category')->orderByDesc('created_at')->get();
        return inertia('Projects/Index', ['projects' => $projects]);
    }

    public function create()
    {
        $this->checkWriteAccess();
        $categories = ProjectCategory::where('is_active', true)->get();
        return inertia('Projects/Form', [
            'categories' => $categories,
            'project' => null
        ]);
    }

    public function store(Request $request)
    {
        $this->checkWriteAccess();
        $validated = $request->validate([
            'category_id' => 'required|exists:project_categories,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'short_description_ar' => 'required|string',
            'short_description_en' => 'nullable|string',
            'full_description_ar' => 'required|string',
            'full_description_en' => 'nullable|string',
            'type' => 'required|in:sustainable,seasonal,relief',
            'status' => 'required|in:active,completed,paused',
            'target_amount' => 'required|numeric|min:0',
            'raised_amount' => 'required|numeric|min:0',
            'beneficiaries_count' => 'nullable|integer|min:0',
            'location_ar' => 'nullable|string',
            'location_en' => 'nullable|string',
            'governorate' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $project = Project::create($validated);

        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('projects', 'public');
                $project->media()->create([
                    'media_type' => 'image',
                    'url' => '/storage/' . $path,
                    'is_cover' => false,
                    'display_order' => 0
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'تم إنشاء المشروع بنجاح');
    }

    public function edit(Project $project)
    {
        $this->checkWriteAccess();
        $categories = ProjectCategory::where('is_active', true)->get();
        $project->load('media');

        return inertia('Projects/Form', [
            'categories' => $categories,
            'project' => $project
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $this->checkWriteAccess();
        $validated = $request->validate([
            'category_id' => 'required|exists:project_categories,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'short_description_ar' => 'required|string',
            'short_description_en' => 'nullable|string',
            'full_description_ar' => 'required|string',
            'full_description_en' => 'nullable|string',
            'type' => 'required|in:sustainable,seasonal,relief',
            'status' => 'required|in:active,completed,paused',
            'target_amount' => 'required|numeric|min:0',
            'raised_amount' => 'required|numeric|min:0',
            'beneficiaries_count' => 'nullable|integer|min:0',
            'location_ar' => 'nullable|string',
            'location_en' => 'nullable|string',
            'governorate' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $project->update($validated);

        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('projects', 'public');
                $project->media()->create([
                    'media_type' => 'image',
                    'url' => '/storage/' . $path,
                    'is_cover' => false,
                    'display_order' => 0
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'تم تحديث المشروع بنجاح');
    }

    public function destroy(Project $project)
    {
        $this->checkWriteAccess();
        foreach ($project->media as $media) {
            $filePath = str_replace('/storage/', '', $media->url);
            Storage::disk('public')->delete($filePath);
        }
        
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'تم حذف المشروع بنجاح');
    }

    public function deleteMedia(ProjectMedia $media)
    {
        $this->checkWriteAccess();
        $filePath = str_replace('/storage/', '', $media->url);
        Storage::disk('public')->delete($filePath);
        
        $media->delete();
        return back()->with('success', 'تم حذف المرفق بنجاح');
    }
}
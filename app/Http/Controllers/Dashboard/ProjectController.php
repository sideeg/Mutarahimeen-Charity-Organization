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
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor', 'finance'])) {
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
            foreach ($request->file('media_files') as $index => $file) {
                $path = $file->store('projects', 'public');
                $project->media()->create([
                    'media_type' => 'image',
                    'url' => '/storage/' . $path,
                    // First uploaded image on a brand-new project automatically becomes the cover
                    'is_cover' => $index === 0,
                    'display_order' => $index
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

            foreach ($request->file('media_files') as $index => $file) {

                if (!$file->isValid()) {
                    \Log::error('Invalid project image upload', [
                        'error' => $file->getError(),
                        'name' => $file->getClientOriginalName(),
                    ]);

                    continue;
                }

                $path = $file->store('projects', 'public');

                \Log::info('Project image uploaded', [
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'full_path' => storage_path('app/public/' . $path),
                    'exists' => Storage::disk('public')->exists($path),
                ]);

                $project->media()->create([
                    'media_type' => 'image',
                    'url' => Storage::disk('public')->url($path),
                    'is_cover' => $index === 0,
                    'display_order' => $index,
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
        $wasCover = $media->is_cover;
        $projectId = $media->project_id;

        $filePath = str_replace('/storage/', '', $media->url);
        Storage::disk('public')->delete($filePath);
        
        $media->delete();

        // If we just deleted the cover photo, promote the next available image automatically
        // so the project never ends up with zero cover and silently falls back to the placeholder.
        if ($wasCover) {
            $nextMedia = ProjectMedia::where('project_id', $projectId)
                ->orderBy('display_order')
                ->first();

            if ($nextMedia) {
                $nextMedia->update(['is_cover' => true]);
            }
        }

        return back()->with('success', 'تم حذف المرفق بنجاح');
    }

    /** Mark a specific media item as the project's cover image, unsetting any previous cover */
    public function setCover(ProjectMedia $media)
    {
        $this->checkWriteAccess();

        ProjectMedia::where('project_id', $media->project_id)
            ->update(['is_cover' => false]);

        $media->update(['is_cover' => true]);

        return back()->with('success', 'تم تعيين صورة الغلاف بنجاح');
    }
}
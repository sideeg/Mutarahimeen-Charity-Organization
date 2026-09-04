<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProjectUpdate;
use App\Models\Project;
use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectUpdateController extends Controller
{
    private function authorizeEditor()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor','finance'])) {
            abort(403, 'غير مصرح لك بالوصول لمتابعة تحديثات المشاريع.');
        }
    }

    public function index()
    {
        $this->authorizeEditor();
        $updates = ProjectUpdate::with('project:id,title_ar')->orderByDesc('published_date')->get();
        return inertia('Updates/Index', ['updates' => $updates]);
    }

    public function create()
    {
        $this->authorizeEditor();
        $projects = Project::where('is_active', true)->get(['id', 'title_ar']);
        return inertia('Updates/Form', ['projects' => $projects, 'update' => null]);
    }

    public function store(Request $request)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'published_date' => 'required|date',
        ]);

        $mediaUrls = [];
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('updates', 'public');
                $mediaUrls[] = '/storage/' . $path;
            }
        }

        ProjectUpdate::create([
            'project_id' => $validated['project_id'],
            'title_ar' => $validated['title_ar'],
            'title_en' => $validated['title_en'],
            'content_ar' => $validated['content_ar'],
            'content_en' => $validated['content_en'],
            'admin_notes' => $validated['admin_notes'],
            'published_date' => $validated['published_date'],
            'media_urls' => $mediaUrls,
        ]);

        return redirect('/admin/updates')->with('success', 'تم حفظ التحديث الميداني بنجاح');
    }

    public function edit(ProjectUpdate $update)
    {
        $this->authorizeEditor();
        $projects = Project::where('is_active', true)->get(['id', 'title_ar']);
        return inertia('Updates/Form', ['projects' => $projects, 'update' => $update]);
    }

    public function update(Request $request, ProjectUpdate $update)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'published_date' => 'required|date',
        ]);

        $mediaUrls = $update->media_urls ?: [];

        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('updates', 'public');
                $mediaUrls[] = '/storage/' . $path;
            }
        }

        $update->update([
            'project_id' => $validated['project_id'],
            'title_ar' => $validated['title_ar'],
            'title_en' => $validated['title_en'],
            'content_ar' => $validated['content_ar'],
            'content_en' => $validated['content_en'],
            'admin_notes' => $validated['admin_notes'],
            'published_date' => $validated['published_date'],
            'media_urls' => $mediaUrls,
        ]);

        return redirect('/admin/updates')->with('success', 'تم تحديث التقرير بنجاح');
    }

    public function destroy(ProjectUpdate $update)
    {
        $this->authorizeEditor();

        $mediaUrls = $update->media_urls ?: [];
        foreach ($mediaUrls as $url) {
            $filePath = str_replace('/storage/', '', $url);
            Storage::disk('public')->delete($filePath);
        }

        $update->delete();
        return redirect('/admin/updates')->with('success', 'تم حذف التقرير الميداني بنجاح');
    }
}
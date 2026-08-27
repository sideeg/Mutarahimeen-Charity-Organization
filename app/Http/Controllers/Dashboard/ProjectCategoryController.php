<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use App\Models\DashboardUser;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    private function authorizeEditor()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor'])) {
            abort(403, 'غير مصرح لك بالوصول لقسم تصنيفات المشاريع.');
        }
    }

    public function index()
    {
        $this->authorizeEditor();
        $categories = ProjectCategory::orderBy('display_order')->get();
        return inertia('Categories/Index', ['categories' => $categories]);
    }

    public function create()
    {
        $this->authorizeEditor();
        return inertia('Categories/Form', ['category' => null]);
    }

    public function store(Request $request)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'icon_name' => 'nullable|string',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        ProjectCategory::create($validated);

        return redirect('/admin/categories')->with('success', 'تم حفظ التصنيف بنجاح');
    }

    public function edit(ProjectCategory $category)
    {
        $this->authorizeEditor();
        return inertia('Categories/Form', ['category' => $category]);
    }

    public function update(Request $request, ProjectCategory $category)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'icon_name' => 'nullable|string',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $category->update($validated);

        return redirect('/admin/categories')->with('success', 'تم تحديث التصنيف بنجاح');
    }

    public function destroy(ProjectCategory $category)
    {
        $this->authorizeEditor();
        
        if ($category->projects()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف هذا التصنيف لارتباطه بمشاريع جارية.');
        }

        $category->delete();
        return redirect('/admin/categories')->with('success', 'تم حذف التصنيف بنجاح');
    }
}
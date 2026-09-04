<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Secure helper to enforce super_admin access gate.
     */
    private function validateSuperAdmin()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        
        if (!$user || $user->role !== 'super_admin') {
            abort(403, 'غير مصرح لك بالوصول لهذا القسم.');
        }
    }

    public function index()
    {
        $this->validateSuperAdmin();

        $users = DashboardUser::orderByDesc('created_at')->get();
        return inertia('Users/Index', ['users' => $users]);
    }

    public function create()
    {
        $this->validateSuperAdmin();

        return inertia('Users/Form', ['user' => null]);
    }

    public function store(Request $request)
    {
        $this->validateSuperAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:dashboard_users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:super_admin,content_editor,finance,membership_manager',
            'is_active' => 'required|boolean',
        ]);

        DashboardUser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => $validated['is_active'],
            'created_by' => session('dashboard_user_id')
        ]);

        return redirect('/admin/users')->with('success', 'تم إضافة المسؤول بنجاح');
    }

    public function edit(DashboardUser $user)
    {
        $this->validateSuperAdmin();

        return inertia('Users/Form', ['user' => $user]);
    }

    public function update(Request $request, DashboardUser $user)
    {
        $this->validateSuperAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:dashboard_users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:super_admin,content_editor,finance,membership_manager',
            'is_active' => 'required|boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'is_active' => $validated['is_active'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password_hash'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect('/admin/users')->with('success', 'تم تحديث بيانات المسؤول بنجاح');
    }

    public function destroy(DashboardUser $user)
    {
        $this->validateSuperAdmin();

        // Prevent users from deleting their own session
        if ($user->id == session('dashboard_user_id')) {
            return back()->with('error', 'لا يمكنك حذف حسابك الحالي أثناء تسجيل الدخول.');
        }

        $user->delete();
        return redirect('/admin/users')->with('success', 'تم إزالة المسؤول بنجاح');
    }
}
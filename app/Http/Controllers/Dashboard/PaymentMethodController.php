<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    private function authorizeFinance()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'finance'])) {
            abort(403, 'غير مصرح لك بإدارة الحسابات وطرق التبرع البنكية.');
        }
    }

    public function index()
    {
        $this->authorizeFinance();
        $methods = PaymentMethod::orderBy('display_order')->get();
        return inertia('PaymentMethods/Index', ['methods' => $methods]);
    }

    public function create()
    {
        $this->authorizeFinance();
        return inertia('PaymentMethods/Form', ['method' => null]);
    }

    public function store(Request $request)
    {
        $this->authorizeFinance();

        $validated = $request->validate([
            'method_name_ar' => 'required|string|max:255',
            'method_name_en' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'instructions_ar' => 'nullable|string',
            'instructions_en' => 'nullable|string',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
            'icon_file' => 'nullable|image|max:1024',
        ]);

        $iconUrl = null;
        if ($request->hasFile('icon_file')) {
            $path = $request->file('icon_file')->store('payment_icons', 'public');
            $iconUrl = '/storage/' . $path;
        }

        PaymentMethod::create(array_merge($validated, [
            'icon_url' => $iconUrl,
        ]));

        return redirect('/admin/payment-methods')->with('success', 'تم حفظ وسيلة الدفع بنجاح');
    }

    public function edit(PaymentMethod $method)
    {
        $this->authorizeFinance();
        return inertia('PaymentMethods/Form', ['method' => $method]);
    }

    public function update(Request $request, PaymentMethod $method)
    {
        $this->authorizeFinance();

        $validated = $request->validate([
            'method_name_ar' => 'required|string|max:255',
            'method_name_en' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'instructions_ar' => 'nullable|string',
            'instructions_en' => 'nullable|string',
            'display_order' => 'required|integer',
            'is_active' => 'required|boolean',
            'icon_file' => 'nullable|image|max:1024',
        ]);

        $updateData = $validated;

        if ($request->hasFile('icon_file')) {
            if ($method->icon_url) {
                $oldPath = str_replace('/storage/', '', $method->icon_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('icon_file')->store('payment_icons', 'public');
            $updateData['icon_url'] = '/storage/' . $path;
        }

        $method->update($updateData);

        return redirect('/admin/payment-methods')->with('success', 'تم تحديث وسيلة الدفع بنجاح');
    }

    public function destroy(PaymentMethod $method)
    {
        $this->authorizeFinance();

        if ($method->icon_url) {
            $filePath = str_replace('/storage/', '', $method->icon_url);
            Storage::disk('public')->delete($filePath);
        }

        $method->delete();
        return redirect('/admin/payment-methods')->with('success', 'تم حذف وسيلة الدفع بنجاح');
    }
}
<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DashboardUser;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** Generate mathematical captcha equation and store answer in session */
    private function generateCaptcha(): string
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        session()->put('login_captcha_result', $num1 + $num2);
        return "{$num1} + {$num2}";
    }

    public function showLogin()
    {
        $captchaQuestion = $this->generateCaptcha();
        
        return inertia('Login', [
            'captcha_question' => $captchaQuestion
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'captcha'  => 'required|integer',
        ], [
            'email.required'    => 'البريد الإلكتروني مطلوب.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'captcha.required'  => 'يرجى إدخال إجابة مسألة الأمان.',
            'captcha.integer'   => 'يجب أن تكون إجابة مسألة الأمان رقماً صحيحاً.',
        ]);

        $expectedCaptcha = session()->get('login_captcha_result');

        // Validate Captcha Answer
        if (is_null($expectedCaptcha) || (int)$request->captcha !== (int)$expectedCaptcha) {
            $this->generateCaptcha(); // Regenerate for the next attempt
            return back()->withErrors(['captcha' => 'إجابة مسألة الأمان غير صحيحة.']);
        }

        $user = DashboardUser::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
            $this->generateCaptcha(); // Regenerate for security
            return back()->withErrors(['email' => 'بيانات الاعتماد المدخلة غير صحيحة.']);
        }

        if (!$user->is_active) {
            $this->generateCaptcha();
            return back()->withErrors(['email' => 'هذا الحساب تم إيقافه مؤقتاً.']);
        }

        // Clean up captcha from session upon login success
        session()->forget('login_captcha_result');

        $request->session()->put('dashboard_user_id', $user->id);
        $user->update(['last_login' => now()]);

          return match($user->role) {
                'membership_manager' => redirect('/admin/volunteers'),
                'content_editor'     => redirect('/admin/news'), 
                default               => redirect()->route('admin.index'),
            };
    }

    public function logout(Request $request)
    {
        $request->session()->forget('dashboard_user_id');
        return redirect()->route('admin.login');
    }
}
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
            'email.email'       => 'صيغة البريد الإلكتروني غير صحيحة.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'captcha.required'  => 'يرجى إدخال إجابة مسألة الأمان.',
            'captcha.integer'   => 'يجب أن تكون إجابة مسألة الأمان رقماً صحيحاً.',
        ]);

        $expectedCaptcha = session()->get('login_captcha_result');

        if (is_null($expectedCaptcha) || (int) $request->captcha !== (int) $expectedCaptcha) {
            $this->generateCaptcha();
            return back()
                ->withErrors(['captcha' => 'إجابة مسألة الأمان غير صحيحة، حاول مرة أخرى.'])
                ->withInput($request->only('email'));
        }

        $user = DashboardUser::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
            $this->generateCaptcha();
            return back()
                ->withErrors(['credentials' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.'])
                ->withInput($request->only('email'));
        }

        if (!$user->is_active) {
            $this->generateCaptcha();
            return back()
                ->withErrors(['account' => 'هذا الحساب تم إيقافه مؤقتاً. يرجى التواصل مع مدير النظام.'])
                ->withInput($request->only('email'));
        }

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
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DashboardUser;

class DashboardAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('dashboard_user_id')) {
            return redirect()->route('admin.login');
        }

        $user = DashboardUser::find($request->session()->get('dashboard_user_id'));

        if (!$user || !$user->is_active) {
            $request->session()->forget('dashboard_user_id');
            return redirect()->route('admin.login');
        }

        // Share authenticated user globally with Inertia
        inertia()->share('auth', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);

        return $next($request);
    }
}
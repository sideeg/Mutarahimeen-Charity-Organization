<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SiteSettingController extends Controller
{
    private function authorizeAdmin()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || $user->role !== 'super_admin') {
            abort(403, 'غير مصرح لك بتعديل الإعدادات العامة للنظام.');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        $settings = SiteSetting::all();
        return inertia('Settings/Index', ['settings' => $settings]);
    }

    public function update(Request $request, SiteSetting $setting)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'value' => 'required|string',
        ]);

        $setting->update($validated);

        // Map database setting keys directly to system .env variables
        $envMap = [
            'mail_host'         => 'MAIL_HOST',
            'mail_port'         => 'MAIL_PORT',
            'mail_username'     => 'MAIL_USERNAME',
            'mail_password'     => 'MAIL_PASSWORD',
            'mail_encryption'   => 'MAIL_ENCRYPTION',
            'mail_from_address' => 'MAIL_FROM_ADDRESS',
            'mail_from_name'    => 'MAIL_FROM_NAME',
        ];

        // If the updated key is an SMTP parameter, write it directly to the .env file
        if (array_key_exists($setting->key, $envMap)) {
            $envKey = $envMap[$setting->key];
            
            if ($this->writeToEnv($envKey, $validated['value'])) {
                try {
                    // Flush the compiled configuration cache and signal background queue workers to restart
                    Artisan::call('config:clear');
                    Artisan::call('queue:restart');
                } catch (\Exception $e) {
                    Log::error("Failed to run cache/queue clear commands: " . $e->getMessage());
                }
            }
        }

        return redirect('/admin/settings')->with('success', 'تم تحديث الإعداد العام وكتابته في ملف النظام بنجاح');
    }

    /** Securely overwrite or append keys inside the system .env file */
    private function writeToEnv(string $key, string $value): bool
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            Log::error("No .env file found at: " . $envPath);
            return false;
        }

        $content = file_get_contents($envPath);
        $key = strtoupper($key);

        // Wrap value in quotes if it contains spaces or special characters
        if (preg_match('/\s/', $value) || preg_match('/[#*$&^()]/', $value)) {
            $value = '"' . str_replace('"', '\\"', $value) . '"';
        }

        $oldLinePattern = "/^{$key}=.*/m";

        if (preg_match($oldLinePattern, $content)) {
            // Overwrite the existing line
            $content = preg_replace($oldLinePattern, "{$key}={$value}", $content);
        } else {
            // Append key to the end of the file if it does not exist
            $content .= "\n{$key}={$value}";
        }

        try {
            file_put_contents($envPath, $content);
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to write to .env for key {$key}: " . $e->getMessage());
            return false;
        }
    }
}
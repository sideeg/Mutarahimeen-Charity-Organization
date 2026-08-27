<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class SiteSetting extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    protected static function booted()
    {
        // Flush settings cache automatically on any updates
        static::updated(function ($setting) {
            Cache::forget("site_setting:{$setting->key}");

            // If SMTP configurations are changed, signal background workers to reload settings instantly
            if (str_starts_with($setting->key, 'mail_')) {
                try {
                    Artisan::call('queue:restart');
                } catch (\Exception $e) {
                    // Fail silently if CLI execution is restricted by server provider
                }
            }
        });
    }

    /** Get a setting value by key, with optional default. */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("site_setting:{$key}", 3600, function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    /** Set (upsert) a setting value and flush its cache. */
    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("site_setting:{$key}");
    }
}
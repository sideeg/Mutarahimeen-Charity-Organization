<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key'         => 'meta_description',
                'value'       => 'منظمة متراحمين الخيرية - مبادرة شبابية سودانية تُعنى بالصحة والتعليم والتكافل الاجتماعي منذ 2019.',
                'description' => 'وصف الموقع لمحركات البحث (SEO)',
            ],
            [
                'key'         => 'footer_copyright_text',
                'value'       => '© ' . date('Y') . ' منظمة متراحمين الخيرية. جميع الحقوق محفوظة.',
                'description' => 'نص حقوق النشر في أسفل الصفحة (Footer)',
            ],
            [
                'key'         => 'google_analytics_id',
                'value'       => '',
                'description' => 'معرف تتبع إحصائيات جوجل Google Analytics (GA4)',
            ],
            [
                'key'         => 'facebook_pixel_id',
                'value'       => '',
                'description' => 'معرف فيسبوك بيكسل Facebook Pixel',
            ],
            // SMTP Configurations
            [
                'key'         => 'mail_host',
                'value'       => 'smtp-relay.brevo.com',
                'description' => 'عنوان خادم البريد الوارد (SMTP Host)',
            ],
            [
                'key'         => 'mail_port',
                'value'       => '587',
                'description' => 'منفذ اتصال خادم البريد (SMTP Port)',
            ],
            [
                'key'         => 'mail_username',
                'value'       => '',
                'description' => 'اسم مستخدم حساب البريد (SMTP Username)',
            ],
            [
                'key'         => 'mail_password',
                'value'       => '',
                'description' => 'كلمة مرور حساب البريد المشفرة (SMTP Password)',
            ],
            [
                'key'         => 'mail_encryption',
                'value'       => 'tls',
                'description' => 'بروتوكول تشفير الاتصال الآمن (tls / ssl)',
            ],
            [
                'key'         => 'mail_from_address',
                'value'       => 'no-reply@motrahimeen.org',
                'description' => 'عنوان البريد الإلكتروني الافتراضي للمرسل (From Email)',
            ],
            [
                'key'         => 'mail_from_name',
                'value'       => 'منظمة متراحمين الخيرية',
                'description' => 'الاسم التعريفي الافتراضي للمرسل (From Name)',
            ],
        ];

        DB::table('site_settings')->insert($settings);
    }
}
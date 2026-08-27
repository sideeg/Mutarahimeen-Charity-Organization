<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VolunteerApplicationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('volunteer_applications')->insert([
            [
                'full_name'         => 'محمد أحمد عثمان',
                'email'             => 'mohammed.volunteer@email.com',
                'phone'             => '0912345678',
                'volunteer_type'    => 'professional',
                'specialization'    => 'طبيب',
                'message_or_skills' => 'طبيب عام بخبرة 5 سنوات، أرغب في المشاركة في الحملات الطبية الميدانية.',
                'status'            => 'new',
                'created_at'        => now()->subDays(3),
            ],
            [
                'full_name'         => 'سارة خالد محمود',
                'email'             => 'sara.design@email.com',
                'phone'             => '0987654321',
                'volunteer_type'    => 'digital',
                'specialization'    => 'مصممة جرافيك',
                'message_or_skills' => 'مصممة جرافيك بخبرة 3 سنوات في أدوبي، يمكنني تصميم حملات بصرية للمنظمة.',
                'status'            => 'reviewed',
                'created_at'        => now()->subDays(10),
            ],
            [
                'full_name'         => 'عمر عبدالرحمن',
                'email'             => 'omar.dev@email.com',
                'phone'             => '0911223344',
                'volunteer_type'    => 'digital',
                'specialization'    => 'مطور مواقع',
                'message_or_skills' => 'مطور ويب متخصص في Laravel وVue.js، يسعدني المساهمة في تطوير وصيانة موقع المنظمة.',
                'status'            => 'contacted',
                'created_at'        => now()->subDays(20),
            ],
            [
                'full_name'         => 'نادية إبراهيم حسن',
                'email'             => 'nadia.lawyer@email.com',
                'phone'             => '0933445566',
                'volunteer_type'    => 'professional',
                'specialization'    => 'محامية',
                'message_or_skills' => 'محامية متخصصة في قانون المنظمات غير الربحية، أستطيع تقديم استشارات قانونية مجانية.',
                'status'            => 'new',
                'created_at'        => now()->subDay(),
            ],
        ]);
    }
}

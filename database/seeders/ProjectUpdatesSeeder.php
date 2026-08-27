<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectUpdatesSeeder extends Seeder
{
    public function run(): void
    {
        $projects = DB::table('projects')->pluck('id', 'title_ar');

        $updates = [
            [
                'project_id'     => $projects['القوافل الطبية'] ?? 2,
                'title_ar'       => 'انطلاق القافلة الطبية الرابعة',
                'title_en'       => 'Launch of the fourth medical convoy',
                'content_ar'     => 'بحمد الله انطلقت القافلة الطبية الرابعة هذا الشهر، وقدمت الفريق الطبي التطوعي استشارات وأدوية مجانية لأكثر من 600 مستفيد في يوم واحد. نشكر جميع الداعمين الذين أسهموا في استمرار هذا المشروع الحيوي.',
                'content_en'     => 'The fourth medical convoy launched this month, with our volunteer medical team providing free consultations and medicine to over 600 beneficiaries in a single day.',
                'media_urls'     => json_encode([
                    'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=800&q=80',
                ]),
                'admin_notes'    => null,
                'published_date' => '2024-05-10',
                'created_at'     => now(),
            ],
            [
                'project_id'     => $projects['الحقيبة الرمضانية'] ?? 1,
                'title_ar'       => 'توزيع أكثر من 1000 حقيبة رمضانية',
                'title_en'       => 'Over 1,000 Ramadan baskets distributed',
                'content_ar'     => 'بفضل تبرعاتكم، تم توزيع أكثر من ألف حقيبة رمضانية على الأسر المحتاجة في أحياء متفرقة من الخرطوم، لتوفير احتياجاتهم الأساسية طوال الشهر الفضيل.',
                'content_en'     => 'Thanks to your donations, over 1,000 Ramadan baskets were distributed to families in need across various neighborhoods of Khartoum.',
                'media_urls'     => json_encode([
                    'https://images.unsplash.com/photo-1594708767771-a7502209ff51?auto=format&fit=crop&w=800&q=80',
                ]),
                'admin_notes'    => null,
                'published_date' => '2024-03-20',
                'created_at'     => now(),
            ],
        ];

        DB::table('project_updates')->insert($updates);
    }
}
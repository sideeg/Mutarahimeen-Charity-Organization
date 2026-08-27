<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = DB::table('dashboard_users')->where('role', 'content_editor')->value('id');

        DB::table('news_articles')->insert([
            [
                'title_ar'        => 'متراحمين تطلق القافلة الطبية الرابعة في الجزيرة',
                'title_en'        => 'Mutrahimeen launches its fourth medical convoy in Al Jazirah',
                'slug'            => 'mutrahimeen-medical-convoy-4-2024',
                'content_ar'      => "بحمد الله، أطلقت منظمة متراحمين الخيرية قافلتها الطبية الرابعة لتقديم استشارات وأدوية مجانية لأهالي ولاية الجزيرة، ضمن جهودها المستمرة لتحسين الوصول إلى الرعاية الصحية للمجتمعات المحرومة.",
                'content_en'      => "Mutrahimeen Charity Organization has launched its fourth medical convoy to provide free consultations and medicine to residents of Al Jazirah State, as part of its ongoing effort to improve healthcare access for underserved communities.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonths(1),
                'deleted_at'      => null,
                'created_at'      => now()->subMonths(1),
                'updated_at'      => now()->subMonths(1),
            ],
            [
                'title_ar'        => 'انطلاق حملة الحقيبة الرمضانية لعام 2024',
                'title_en'        => 'Launch of the 2024 Ramadan Basket Campaign',
                'slug'            => 'mutrahimeen-ramadan-basket-2024',
                'content_ar'      => "دشّنت متراحمين الخيرية حملتها السنوية لتوزيع الحقائب الرمضانية، والتي تستهدف آلاف الأسر المحتاجة في أحياء الخرطوم المختلفة، لضمان استمرار الأمن الغذائي طوال الشهر الفضيل.",
                'content_en'      => "Mutrahimeen Charity has launched its annual Ramadan Basket campaign, targeting thousands of families in need across Khartoum's neighborhoods to ensure food security throughout the holy month.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1594708767771-a7502209ff51?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonths(3),
                'deleted_at'      => null,
                'created_at'      => now()->subMonths(3),
                'updated_at'      => now()->subMonths(3),
            ],
            [
                'title_ar'        => 'متراحمين تحتفل بمرور خمس سنوات على انطلاقتها',
                'title_en'        => 'Mutrahimeen celebrates five years since its founding',
                'slug'            => 'mutrahimeen-fifth-anniversary',
                'content_ar'      => "احتفلت أسرة متراحمين الخيرية بمرور خمس سنوات على انطلاقتها من الخرطوم، مستعرضة أبرز إنجازاتها في مجالات الصحة والتعليم والتكافل الاجتماعي، وشكرت كل من ساهم في دعم مسيرتها.",
                'content_en'      => "Mutrahimeen Charity celebrated five years since its founding in Khartoum, highlighting its key achievements in health, education, and social solidarity, and thanking everyone who supported its journey.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140e2b8?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonths(6),
                'deleted_at'      => null,
                'created_at'      => now()->subMonths(6),
                'updated_at'      => now()->subMonths(6),
            ],
        ]);
    }
}
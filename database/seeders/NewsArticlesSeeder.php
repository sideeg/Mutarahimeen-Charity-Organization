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
                'title_ar'        => 'متراحمين تحتفل بإكمال عامها الأول',
                'title_en'        => 'Mutrahimeen celebrates completing its first year',
                'slug'            => 'mutrahimeen-first-anniversary-2020',
                'content_ar'      => "بحمد الله، احتفلت أسرة متراحمين الخيرية بإكمال عامها الأول منذ انطلاقتها في 28 مارس 2019، مستذكرة أبرز محطاتها في هذا العام: مشروع الحقيبة الرمضانية، إفطارات الصائمين، وفرحة الأطفال في العيد. شكرت المنظمة كل من ساهم معها في مد يد العون، مؤكدة استمرارها بروح الشباب التطوعية التي انطلقت بها: كنّا متراحمين وسنبقى متراحمين.",
                'content_en'      => "Mutrahimeen Charity celebrated completing its first year since its founding on March 28, 2019, reflecting on its key milestones: the Ramadan Basket project, iftar meals for fasting travelers, and bringing joy to children during Eid. The organization thanked everyone who contributed, reaffirming its volunteer spirit: we were Mutrahimeen and we will remain Mutrahimeen.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1594708767771-a7502209ff51?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subYears(1)->setMonth(3)->setDay(28),
                'deleted_at'      => null,
                'created_at'      => now()->subYears(1)->setMonth(3)->setDay(28),
                'updated_at'      => now()->subYears(1)->setMonth(3)->setDay(28),
            ],
            [
                'title_ar'        => 'انطلاق تحدي الحقيبة الرمضانية الأسبوعي',
                'title_en'        => 'Launch of the weekly Ramadan Basket pledge challenge',
                'slug'            => 'mutrahimeen-ramadan-basket-challenge',
                'content_ar'      => "دشّنت متراحمين الخيرية فكرتها المعتادة في مشروع الحقيبة الرمضانية لهذا العام: تحدٍ أسبوعي بسيط يلتزم فيه كل داعم بمبلغ صغير يحوّله نهاية كل أسبوع، ليجتمع عشرة أشخاص فيكوّنوا معاً ثمن حقيبة رمضانية كاملة لأسرة محتاجة. المبادرة تستهدف أيضاً المغتربين الراغبين في المساهمة من خارج السودان.",
                'content_en'      => "Mutrahimeen Charity launched its familiar approach to this year's Ramadan Basket project: a simple weekly pledge challenge where each supporter commits to a small recurring amount, so that ten people together cover the cost of one full Ramadan basket for a family in need. The initiative also invites Sudanese expatriates abroad to contribute.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140e2b8?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonths(5),
                'deleted_at'      => null,
                'created_at'      => now()->subMonths(5),
                'updated_at'      => now()->subMonths(5),
            ],
            [
                'title_ar'        => 'متراحمين: نصلكم بكم أينما كنتم في الخرطوم',
                'title_en'        => 'Mutrahimeen: reaching you wherever you are in Khartoum',
                'slug'            => 'mutrahimeen-reach-you-khartoum',
                'content_ar'      => "أكدت منظمة متراحمين الخيرية استمرار جهودها التطوعية في التواصل مع المحتاجين داخل الخرطوم وضواحيها، داعية كل من يرغب في المساعدة أو طلب الدعم للتواصل المباشر معها، انطلاقاً من شعارها الدائم: عاوز تساعد؟ خليك قريب.",
                'content_en'      => "Mutrahimeen Charity reaffirmed its ongoing volunteer efforts to reach people in need across Khartoum and its outskirts, inviting anyone who wants to help — or needs support — to reach out directly, in line with its enduring motto: want to help? Stay close.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonths(2),
                'deleted_at'      => null,
                'created_at'      => now()->subMonths(2),
                'updated_at'      => now()->subMonths(2),
            ],
        ]);
    }
}
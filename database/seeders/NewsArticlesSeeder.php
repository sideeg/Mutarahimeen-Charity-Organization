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
                'title_ar'        => 'متراحمين تستجيب لموجة نزوح الفاشر',
                'title_en'        => 'Mutrahimeen responds to the El Fasher displacement wave',
                'slug'            => 'mutrahimeen-el-fasher-response',
                'content_ar'      => "كانت فترة توافد النازحين من مدينة الفاشر حاملة لأقسى مشاهد المعاناة الإنسانية. تحركت فرق متراحمين الخيرية ميدانياً لتوزيع الفرش والأغطية على العائلات في مخيمات الخيام، في استجابة عاجلة لواحدة من أصعب موجات النزوح التي شهدتها البلاد.",
                'content_en'      => "The period of displacement from El Fasher city carried some of the harshest scenes of human suffering. Mutrahimeen Charity teams moved on the ground to distribute mats and covers to families in tent camps, in urgent response to one of the country's most difficult displacement waves.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1541943180-25783b78f6f8?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonths(4),
                'deleted_at'      => null,
                'created_at'      => now()->subMonths(4),
                'updated_at'      => now()->subMonths(4),
            ],
            [
                'title_ar'        => 'قافلة الخير الطبية تصل نهر النيل',
                'title_en'        => "Al-Khair Medical Convoy reaches River Nile State",
                'slug'            => 'mutrahimeen-khair-medical-convoy-river-nile',
                'content_ar'      => "بحمد الله وصلت قافلة الخير الطبية إلى محليات بربر والعكد بولاية نهر النيل، لتقدم استشارات طبية مجانية وأدوية لمئات المستفيدين، ضمن سلسلة الأيام العلاجية والقوافل الطبية التي تنفذها متراحمين في الولايات المختلفة.",
                'content_en'      => "Al-Khair Medical Convoy reached the Berber and Al-Akad localities of River Nile State, providing free medical consultations and medicine to hundreds of beneficiaries, as part of Mutrahimeen's ongoing series of treatment days and medical convoys across the country's states.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonths(7),
                'deleted_at'      => null,
                'created_at'      => now()->subMonths(7),
                'updated_at'      => now()->subMonths(7),
            ],
            [
                'title_ar'        => 'دعم مراكز علاج الكوليرا في الخرطوم',
                'title_en'        => "Supporting cholera treatment centers in Khartoum",
                'slug'            => 'mutrahimeen-cholera-centers-support',
                'content_ar'      => "تفشي الأمراض في مجتمعنا حرب نخوضها جميعًا. في ظل تفشي وباء الكوليرا، بادرت متراحمين الخيرية بدعم مراكز العلاج بالدربات (المحاليل الوريدية) والمستلزمات الطبية الأساسية في عدد من أحياء الخرطوم، بالتعاون مع الكوادر الطبية المتطوعة.",
                'content_en'      => "Disease outbreaks in our community are a battle we all fight together. Amid a cholera outbreak, Mutrahimeen Charity stepped in to support treatment centers with IV fluids and essential medical supplies across several Khartoum neighborhoods, in cooperation with volunteer medical staff.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1584982751601-97dcc096659c?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonths(10),
                'deleted_at'      => null,
                'created_at'      => now()->subMonths(10),
                'updated_at'      => now()->subMonths(10),
            ],
            [
                'title_ar'        => 'مشاريع صغيرة كبيرة في أعين مستحقيها',
                'title_en'        => "Small projects, big in the eyes of those who deserve them",
                'slug'            => 'mutrahimeen-small-business-ownership',
                'content_ar'      => "ضمن برنامج التمكين الاقتصادي، سلّمت متراحمين الخيرية عدداً من الأسر المحتاجة مشاريع دخل صغيرة يديرونها بأنفسهم: عربة آيسكريم، مشروع تبريد وتجميد، محل طعمية، وأكشاك شاي، لتكون بداية طريق نحو الاستقلال المادي.",
                'content_en'      => "As part of its economic empowerment program, Mutrahimeen Charity handed over a number of small, self-managed income projects to families in need — an ice cream cart, a refrigeration project, a falafel shop, and tea stands — marking the start of a path toward financial independence.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonths(2),
                'deleted_at'      => null,
                'created_at'      => now()->subMonths(2),
                'updated_at'      => now()->subMonths(2),
            ],
            [
                'title_ar'        => 'انطلاق حملة كسوة العيد لعام 2026',
                'title_en'        => "Launch of the 2026 Eid Clothing Campaign",
                'slug'            => 'mutrahimeen-eid-clothing-2026',
                'content_ar'      => "إنما العيد للأطفال فرحة. دشّنت متراحمين الخيرية حملتها السنوية لتوزيع كسوة العيد على أطفال الأسر المحتاجة في أحياء الخرطوم، وهي حملة مستمرة منذ عام 2018 دون انقطاع، بمشاركة فرق تطوعية لفرز الملابس وتوزيعها مباشرة على المستفيدين.",
                'content_en'      => "Eid is, above all, joy for children. Mutrahimeen Charity launched its annual campaign to distribute new Eid clothes to children of families in need across Khartoum — a campaign that has run uninterrupted since 2018, with volunteer teams sorting and distributing directly to beneficiaries.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1607344645866-009c320b63e0?auto=format&fit=crop&w=1200&q=80',
                'status'          => 'published',
                'author_id'       => $authorId,
                'published_at'    => now()->subMonth(),
                'deleted_at'      => null,
                'created_at'      => now()->subMonth(),
                'updated_at'      => now()->subMonth(),
            ],
        ]);
    }
}
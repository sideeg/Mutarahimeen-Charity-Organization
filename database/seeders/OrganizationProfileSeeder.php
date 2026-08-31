<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organization_profiles')->insert([
            'name_ar'              => 'منظمة متراحمين الخيرية',
            'name_en'               => 'Mutrahimeen Charity Organization',
            'about_text_ar'         => 'نحن شباب جامعات وخريجون خرجنا من بيوتنا قاصدين التطوع وعمل الخير. تأسست منظمة متراحمين الخيرية في الخرطوم بتاريخ 28 مارس 2019م، كمبادرة شبابية سودانية تطوعية بحتة، انطلقت من رغبة صادقة في مد يد العون لكل محتاج. نعمل على تقديم الدعم في مجالات الإغاثة الموسمية والصحة والتكافل الاجتماعي، مؤمنين بأن العطاء طريق يوصلنا سوياً "يداً بيد نحو الجنة".',
            'about_text_en'         => 'We are university students and graduates who left our homes to volunteer and do good. Mutrahimeen Charity Organization was founded in Khartoum on March 28, 2019, as a purely volunteer-driven Sudanese youth initiative born from a genuine desire to extend a helping hand to those in need. We work across seasonal relief, health, and social solidarity programs, believing that giving is a path that leads us together — hand in hand towards Jannah.',
            'vision_ar'             => 'أن نكون يداً بيد نحو مجتمع متكافل خالٍ من الحاجة، نصل فيه إلى كل محتاج بحب ورحمة.',
            'vision_en'             => 'To be hand-in-hand toward a compassionate, self-sufficient society — reaching every person in need with love and mercy.',
            'mission_ar'            => 'تقديم دعم مستدام ومؤثر يمكّننا من بناء روابط قوية وهادفة مع المجتمعات المحتاجة، عبر برامج الإغاثة الموسمية والصحة والتكافل الاجتماعي، بالشراكة مع المجتمع المحلي وبسواعد شبابية تطوعية بحتة.',
            'mission_en'            => 'To deliver sustainable, impactful support that builds strong and meaningful connections with communities in need, through seasonal relief, health, and social solidarity programs — carried out entirely by volunteer youth in partnership with local communities.',
            'marketing_message_ar'  => 'يد بيد نحو الجنة',
            'marketing_message_en'  => 'Hand in hand towards Jannah',
            'email'                 => 'info@motrahimeen.org',
            'phone'                 => '0900000000',
            'whatsapp_link'         => 'https://wa.me/249900000000',
            'address_ar'            => 'الخرطوم، السودان',
            'address_en'            => 'Khartoum, Sudan',
            'logo_url'              => 'images/logo.jpg',
        ]);
    }
}
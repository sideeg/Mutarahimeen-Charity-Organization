<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organization_profiles')->insert([
            'name_ar'               => 'منظمة متراحمين الخيرية',
            'name_en'               => 'Mutrahimeen Charity Organization',
            'about_text_ar'         => 'نحن شباب جامعات وخريجون خرجنا من بيوتنا قاصدين التطوع وعمل الخير. منظمة متراحمين الخيرية مبادرة شبابية سودانية انطلقت من الخرطوم عام 2019 لتكون يداً ممدودة للمحتاجين، ونعمل على تقديم الدعم الشامل في مجالات الصحة والتعليم والتكافل الاجتماعي وتنمية المجتمع لتحقيق أثر إيجابي مستدام.',
            'about_text_en'         => 'We are university students and graduates who left our homes to volunteer and do good. Mutrahimeen Charity Organization is a Sudanese youth initiative founded in Khartoum in 2019, dedicated to uplifting communities through compassionate initiatives, sustainable projects, and collaborative partnerships that make a lasting difference.',
            'vision_ar'             => 'أن نكون يداً بيد نحو مجتمع متكافل خالٍ من الحاجة، نصل فيه إلى كل محتاج بحب ورحمة.',
            'vision_en'             => 'To be hand-in-hand toward a compassionate, self-sufficient society — reaching every person in need with love and mercy.',
            'mission_ar'            => 'تقديم دعم مستدام ومؤثر يمكّننا من بناء روابط قوية وهادفة مع المجتمعات المحتاجة، عبر برامج الصحة والتعليم والتكافل الاجتماعي والتمكين الاقتصادي، بالشراكة مع المجتمع المحلي.',
            'mission_en'            => 'To deliver sustainable, impactful support that builds strong and meaningful connections with communities in need, through health, education, social solidarity, and economic empowerment programs, in partnership with local communities.',
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
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
            'about_text_ar'         => 'أهلاً بك في متراحمين، حيث نؤمن أن الإنسان يستحق أن يعيش متعافيًا، منتجًا، مستورًا. تأسست منظمة متراحمين الخيرية في الخرطوم بتاريخ 28 مارس 2019م، كمبادرة شبابية سودانية تطوعية بحتة، ومن هنا شرعت مشاريعنا لتصل إلى عمق المعاناة وتلامس واقع الناس؛ من الإغاثة الموسمية والدعم الطبي إلى دعم النازحين والتمكين الاقتصادي للأسر المحتاجة.',
            'about_text_en'         => 'Welcome to Mutrahimeen, where we believe every person deserves to live healthy, productive, and dignified. Mutrahimeen Charity Organization was founded in Khartoum on March 28, 2019, as a purely volunteer-driven Sudanese youth initiative. From here, our projects set out to reach the depth of suffering and touch people\'s real lives — from seasonal relief and medical support to displacement response and economic empowerment for families in need.',
            'vision_ar'             => 'أن نكون يداً بيد نحو مجتمع متكافل خالٍ من الحاجة، نصل فيه إلى كل محتاج بحب ورحمة.',
            'vision_en'             => 'To be hand-in-hand toward a compassionate, self-sufficient society — reaching every person in need with love and mercy.',
            'mission_ar'            => 'تقديم دعم مستدام ومؤثر يصل إلى عمق المعاناة ويلامس واقع الناس، عبر برامج الإغاثة الموسمية والرعاية الصحية ودعم النازحين والتمكين الاقتصادي، بسواعد شبابية تطوعية بحتة وبالشراكة مع المجتمع المحلي.',
            'mission_en'            => 'To deliver sustainable, impactful support that reaches the depth of suffering and touches people\'s real lives, through seasonal relief, healthcare, displacement support, and economic empowerment programs — carried out entirely by volunteer youth in partnership with local communities.',
            'marketing_message_ar'  => 'متراحمين بكل حب',
            'marketing_message_en'  => 'Mutrahimeen, with all love',
            'email'                 => 'info@motrahmen.org',
            'phone'                 => '249123113973',
            'whatsapp_link'         => 'https://wa.me/256766699449',
            'address_ar'            => 'الخرطوم، السودان',
            'address_en'            => 'Khartoum, Sudan',
            'logo_url'              => 'images/logo.jpg',
        ]);
    }
}
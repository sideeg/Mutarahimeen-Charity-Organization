<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialLinksSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            [
                'platform_name' => 'فيسبوك',
                'url'           => 'https://www.facebook.com/mutrahmeen',
                'icon_name'     => 'facebook',
                'display_order' => 1,
                'is_active'     => true,
            ],
            [
                'platform_name' => 'انستغرام',
                'url'           => 'https://instagram.com/motrahimeen',
                'icon_name'     => 'instagram',
                'display_order' => 2,
                'is_active'     => true,
            ],
            [
                'platform_name' => 'منصة X',
                'url'           => 'https://twitter.com/motrahimeen',
                'icon_name'     => 'x',
                'display_order' => 3,
                'is_active'     => true,
            ],
            [
                'platform_name' => 'لينكدإن',
                'url'           => 'https://www.linkedin.com/company/motrahimeen-متراحمين-الخيرية/',
                'icon_name'     => 'linkedin',
                'display_order' => 4,
                'is_active'     => true,
            ],
            [
                'platform_name' => 'واتساب',
                'url'           => 'https://wa.me/249900000000',
                'icon_name'     => 'whatsapp',
                'display_order' => 5,
                'is_active'     => true,
            ],
        ];

        DB::table('social_links')->insert($links);
    }
}
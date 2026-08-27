<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnersSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['ar' => 'جمعية الهلال الأحمر السوداني', 'en' => 'Sudanese Red Crescent'],
            ['ar' => 'شركة سوداني للاتصالات',        'en' => 'Sudani Telecommunications'],
            ['ar' => 'شركة زين للاتصالات',            'en' => 'Zain Telecommunications'],
            ['ar' => 'مبادرات شبابية سودانية',         'en' => 'Sudanese Youth Initiatives'],
            ['ar' => 'جمعية أوتاد الخيرية',            'en' => 'Awtad Charity Association'],
        ];

        foreach ($partners as $index => $data) {
            DB::table('partners')->insert([
                'name_ar'       => $data['ar'],
                'name_en'       => $data['en'],
                'logo_url'      => null,
                'website_url'   => null,
                'display_order' => $index + 1,
                'is_active'     => true,
            ]);
        }
    }
}
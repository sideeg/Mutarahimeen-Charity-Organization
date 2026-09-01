<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImpactStatsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('impact_stats')->insert([
            [
                'label_ar'        => 'مستفيد من برامجنا',
                'label_en'        => 'beneficiaries reached',
                'number_value'    => '20',
                'suffix'          => 'K+',
                'description_ar'  => 'مستفيد من مختلف برامج ومشاريع المنظمة',
                'description_en'  => 'Beneficiaries across all our programs and projects',
                'source_type'     => 'manual',
                'calculation_key' => null,
                'icon_name'       => 'hand-heart',
                'display_order'   => 1,
                'is_active'       => true,
            ],
            [
                'label_ar'        => 'برنامج ومشروع نشط',
                'label_en'        => 'active programs & projects',
                'number_value'    => '13',
                'suffix'          => '+',
                'description_ar'  => 'من الإغاثة الموسمية إلى الرعاية الصحية والتمكين الاقتصادي',
                'description_en'  => 'From seasonal relief to healthcare and economic empowerment',
                'source_type'     => 'auto_calculated',
                'calculation_key' => 'total_projects_completed',
                'icon_name'       => 'check-circle',
                'display_order'   => 2,
                'is_active'       => true,
            ],
            [
                'label_ar'        => 'متطوع نشط',
                'label_en'        => 'active volunteers',
                'number_value'    => '150',
                'suffix'          => '+',
                'description_ar'  => 'شاب وشابة يعملون معنا ميدانياً',
                'description_en'  => 'Young men and women working with us on the ground',
                'source_type'     => 'manual',
                'calculation_key' => null,
                'icon_name'       => 'users',
                'display_order'   => 3,
                'is_active'       => true,
            ],
            [
                'label_ar'        => 'عام من العطاء',
                'label_en'        => 'years of giving',
                'number_value'    => (string) (now()->year - 2019),
                'suffix'          => '+',
                'description_ar'  => 'منذ انطلاقتنا في الخرطوم بتاريخ 28 مارس 2019',
                'description_en'  => 'Since our founding in Khartoum on March 28, 2019',
                'source_type'     => 'manual',
                'calculation_key' => null,
                'icon_name'       => 'calendar',
                'display_order'   => 4,
                'is_active'       => true,
            ],
        ]);
    }
}
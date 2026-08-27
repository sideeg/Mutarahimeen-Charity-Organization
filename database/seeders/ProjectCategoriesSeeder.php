<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['ar' => 'المجال الطبي',              'en' => 'Medical Field',            'icon' => 'stethoscope',     'order' => 1],
            ['ar' => 'التدريب والتطوير',           'en' => 'Training & Development',   'icon' => 'graduation-cap',  'order' => 2],
            ['ar' => 'مشاريع الدخل الثابت',        'en' => 'Fixed Income Projects',    'icon' => 'briefcase',       'order' => 3],
            ['ar' => 'البرامج الخيرية الموسمية',    'en' => 'Seasonal Charity Programs','icon' => 'calendar-heart',  'order' => 4],
            ['ar' => 'توزيع الوجبات والإفطار',      'en' => 'Meal Distribution',        'icon' => 'utensils',        'order' => 5],
        ];

        foreach ($categories as $cat) {
            DB::table('project_categories')->insert([
                'name_ar'        => $cat['ar'],
                'name_en'        => $cat['en'],
                'description_ar' => null,
                'icon_name'      => $cat['icon'],
                'display_order'  => $cat['order'],
                'is_active'      => true,
            ]);
        }
    }
}
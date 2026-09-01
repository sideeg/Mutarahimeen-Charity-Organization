<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['ar' => 'المجال الطبي',                 'en' => 'Medical Field',                'icon' => 'stethoscope',    'order' => 1],
            ['ar' => 'الإغاثة الموسمية',              'en' => 'Seasonal Relief',              'icon' => 'calendar-heart', 'order' => 2],
            ['ar' => 'الطوارئ ودعم النازحين',          'en' => 'Emergency & Displacement Support', 'icon' => 'tent',        'order' => 3],
            ['ar' => 'التمكين الاقتصادي',             'en' => 'Economic Empowerment',         'icon' => 'briefcase',      'order' => 4],
            ['ar' => 'البرامج الدينية والتعليمية',     'en' => 'Religious & Educational Programs', 'icon' => 'book-open',  'order' => 5],
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
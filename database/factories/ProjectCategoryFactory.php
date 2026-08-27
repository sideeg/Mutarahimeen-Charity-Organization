<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectCategoryFactory extends Factory
{
    // Real categories based on Mutrahimeen's actual program areas
    private static array $categories = [
        ['ar' => 'المجال الطبي',             'en' => 'Medical Field',             'icon' => 'stethoscope'],
        ['ar' => 'التدريب والتطوير',          'en' => 'Training & Development',    'icon' => 'graduation-cap'],
        ['ar' => 'مشاريع الدخل الثابت',       'en' => 'Fixed Income Projects',     'icon' => 'briefcase'],
        ['ar' => 'البرامج الخيرية الموسمية',   'en' => 'Seasonal Charity Programs', 'icon' => 'calendar-heart'],
        ['ar' => 'توزيع الوجبات والإفطار',     'en' => 'Meal Distribution',         'icon' => 'utensils'],
    ];

    public function definition(): array
    {
        $category = $this->faker->unique()->randomElement(self::$categories);

        return [
            'name_ar'        => $category['ar'],
            'name_en'        => $category['en'],
            'description_ar' => null,
            'icon_name'      => $category['icon'],
            'display_order'  => 0,
            'is_active'      => true,
        ];
    }
}
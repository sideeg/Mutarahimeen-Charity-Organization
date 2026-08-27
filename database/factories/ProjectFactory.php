<?php

namespace Database\Factories;

use App\Models\ProjectCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    private static array $governorates = [
        'الخرطوم', 'الجزيرة', 'النيل الأزرق', 'القضارف',
        'كسلا', 'البحر الأحمر', 'شمال كردفان', 'جنوب كردفان',
        'دارفور', 'سنار', 'نهر النيل', 'الشمالية',
    ];

    public function definition(): array
    {
        $targetAmount = $this->faker->randomElement([
            90_000_000, 60_000_000, 45_000_000, 30_000_000, 25_000_000, 70_000_000,
        ]);
        $raisedPct    = $this->faker->randomFloat(2, 0.1, 1.0);

        return [
            'category_id'          => ProjectCategory::factory(),
            'title_ar'             => $this->faker->randomElement([
                'الحقيبة الرمضانية',
                'القوافل الطبية',
                'إفطار عابر السبيل',
                'توزيع لحوم الأضاحي',
                'كسوة الشتاء',
                'مصادر الدخل الثابتة',
                'برنامج التدريب والتطوير',
                'توزيع الوجبات',
            ]),
            'title_en'             => null,
            'short_description_ar' => $this->faker->sentence(12),
            'full_description_ar'  => $this->faker->paragraph(4),
            'type'                 => $this->faker->randomElement(['sustainable', 'seasonal', 'relief']),
            'status'               => $this->faker->randomElement(['active', 'completed', 'paused']),
            'target_amount'        => $targetAmount,
            'raised_amount'        => round($targetAmount * $raisedPct),
            'beneficiaries_count'  => $this->faker->numberBetween(50, 5000),
            'location_ar'          => 'حي ' . $this->faker->word(),
            'governorate'          => $this->faker->randomElement(self::$governorates),
            'start_date'           => $this->faker->dateTimeBetween('-3 years', '-6 months')->format('Y-m-d'),
            'end_date'             => $this->faker->optional()->dateTimeBetween('-6 months', '+1 year')?->format('Y-m-d'),
            'is_featured'          => false,
            'is_active'            => true,
            'display_order'        => 0,
            'deleted_at'           => null,
        ];
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }

    public function active(): static
    {
        return $this->state(['status' => 'active']);
    }

    public function completed(): static
    {
        return $this->state([
            'status'        => 'completed',
            'raised_amount' => fn (array $attrs) => $attrs['target_amount'],
        ]);
    }
}
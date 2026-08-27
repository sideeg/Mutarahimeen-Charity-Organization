<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectUpdateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id'     => Project::factory(),
            'title_ar'       => $this->faker->randomElement([
                'اكتملت المرحلة الأولى من المشروع',
                'تم تسليم المستفيدين الأوائل',
                'تقرير المتابعة الشهري',
                'بدأنا بالمرحلة الثانية بفضلكم',
                'توثيق ميداني من موقع المشروع',
            ]),
            'content_ar'     => $this->faker->paragraph(3),
            'media_urls'     => json_encode(array_map(
                fn () => $this->faker->imageUrl(800, 600),
                range(1, $this->faker->numberBetween(1, 3))
            )),
            'admin_notes'    => $this->faker->optional()->sentence(),
            'published_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}

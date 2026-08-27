<?php

namespace Database\Factories;

use App\Models\DashboardUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->randomElement([
            'متراحمين تطلق القافلة الطبية الرابعة في الجزيرة',
            'تقرير الإنجازات السنوي',
            'انطلاق حملة الحقيبة الرمضانية',
            'شراكة جديدة مع مبادرات المجتمع المدني',
            'متراحمين في أحياء الخرطوم الطرفية',
            'اختتام حملة كسوة الشتاء بنجاح',
            'توزيع لحوم الأضاحي على الأسر المحتاجة',
        ]);

        return [
            'title_ar'        => $title,
            'slug'            => Str::slug($title . '-' . $this->faker->unique()->numberBetween(1, 9999)),
            'content_ar'      => implode("\n\n", $this->faker->paragraphs(5)),
            'cover_image_url' => $this->faker->randomElement([
    'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1594708767771-a7502209ff51?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1531206715517-5c0ba140e2b8?auto=format&fit=crop&w=800&q=80',
]),
            'status'          => $this->faker->randomElement(['draft', 'published', 'archived']),
            'author_id'       => DashboardUser::factory(),
            'published_at'    => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'deleted_at'      => null,
        ];
    }

    public function published(): static
    {
        return $this->state([
            'status'       => 'published',
            'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ]);
    }
}
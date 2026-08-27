<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectMediaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id'    => Project::factory(),
            'media_type'    => $this->faker->randomElement(['image', 'video']),
            'url' => $this->faker->randomElement([
    'https://images.unsplash.com/photo-1541913496-2246de0d56c4?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1200&q=80',
]),
            'caption_ar'    => $this->faker->optional()->sentence(6),
            'is_cover'      => True,
            'display_order' => $this->faker->numberBetween(0, 10),
        ];
    }

    public function cover(): static
    {
        return $this->state(['is_cover' => true, 'media_type' => 'image']);
    }

    public function video(): static
    {
        return $this->state(['media_type' => 'video']);
    }
}

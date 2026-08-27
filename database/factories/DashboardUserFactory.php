<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class DashboardUserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'          => $this->faker->name(),
            'email'         => $this->faker->unique()->safeEmail(),
            'password_hash' => Hash::make('password'),
            'role'          => $this->faker->randomElement(['content_editor', 'finance']),
            'is_active'     => true,
            'last_login'    => $this->faker->optional()->dateTimeBetween('-30 days', 'now'),
            'created_by'    => null,
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(['role' => 'super_admin']);
    }

    public function contentEditor(): static
    {
        return $this->state(['role' => 'content_editor']);
    }

    public function finance(): static
    {
        return $this->state(['role' => 'finance']);
    }
}

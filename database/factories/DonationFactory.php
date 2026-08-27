<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id'            => $this->faker->boolean(80) ? Project::factory() : null,
            'donor_name'            => $this->faker->optional(0.7)->name(),
            'email'                 => $this->faker->optional(0.6)->safeEmail(),
            'phone'                 => $this->faker->optional(0.8)->phoneNumber(),
            'amount'                => $this->faker->randomElement([
                500, 1000, 2000, 5000, 10000, 25000, 50000, 100000,
            ]),
            'payment_method'        => $this->faker->randomElement(['bankak', 'fawri', 'mycash', 'bank_transfer']),
            'donation_type'         => $this->faker->randomElement(['one_time', 'recurring']),
            'status'                => $this->faker->randomElement(['pending', 'confirmed', 'failed']),
            'transaction_reference' => $this->faker->optional(0.8)->bothify('TXN-########'),
            'admin_notes'           => $this->faker->optional(0.3)->sentence(),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(['status' => 'confirmed']);
    }

    public function general(): static
    {
        return $this->state(['project_id' => null]);
    }
}

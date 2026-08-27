<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerApplicationFactory extends Factory
{
    private static array $professionalSpecs = [
        'طبيب', 'محامي', 'مهندس', 'معلم', 'محاسب', 'صيدلاني', 'ممرض',
    ];

    private static array $digitalSpecs = [
        'مصمم جرافيك', 'مطور مواقع', 'مدير محتوى', 'مصور فيديو',
        'متخصص تسويق إلكتروني', 'مبرمج', 'مدير وسائل التواصل',
    ];

    public function definition(): array
    {
        $type = $this->faker->randomElement(['professional', 'digital']);

        return [
            'full_name'         => $this->faker->name(),
            'email'             => $this->faker->safeEmail(),
            'phone'             => $this->faker->phoneNumber(),
            'volunteer_type'    => $type,
            'specialization'    => $type === 'professional'
                ? $this->faker->randomElement(self::$professionalSpecs)
                : $this->faker->randomElement(self::$digitalSpecs),
            'message_or_skills' => $this->faker->paragraph(2),
            'status'            => $this->faker->randomElement(['new', 'reviewed', 'contacted']),
        ];
    }
}

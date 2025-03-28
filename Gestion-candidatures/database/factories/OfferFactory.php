<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'company_name' => fake()->company(),
            'location' => fake()->city(),
            'salary' => fake()->optional(0.7)->randomFloat(2, 20000, 150000),
            'employment_type' => fake()->randomElement(['Full-time', 'Part-time', 'Contract', 'Freelance', 'Internship']),
            'experience_level' => fake()->randomElement(['Entry-level', 'Mid-level', 'Senior', 'Manager', 'Executive']),
            'required_skills' => json_encode(fake()->randomElements(['PHP', 'JavaScript', 'React', 'Vue', 'Laravel', 'MySQL', 'Python', 'AWS'], fake()->numberBetween(2, 5))),
            'deadline' => fake()->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
            'is_active' => fake()->boolean(80),
            'image' => fake()->optional(0.5)->imageUrl(),
            'user_id' => \App\Models\User::factory(),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'updated_at' => function (array $attributes) {
            return $attributes['created_at'];
            },
        ];
    }
}

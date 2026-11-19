<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     * eatery_id comes from the relationship: $eatery->reviews()->saveMany(...)
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'), // a random seeded reviewer
            'rating' => fake()->numberBetween(1, 5),
            'body' => fake()->sentence(12),                  // always longer than 10 characters
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'), // different dates so "newest first" shows
        ];
    }
}

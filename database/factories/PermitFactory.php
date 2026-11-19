<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permit>
 */
class PermitFactory extends Factory
{
    /**
     * Define the model's default state.
     * eatery_id is not set here because the permit is always created
     * through the eatery: $eatery->permit()->create(...)
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // DVO-2026-1xxxx (5 digits) so it matches /^DVO-\d{4}-\d{4,5}$/
            // and never clashes with my own 4-digit permit number
            'permit_no' => 'DVO-2026-' . fake()->unique()->numerify('1####'),
            'expires_on' => fake()->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
        ];
    }

    /**
     * expired() state: the expiry date is already in the past.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_on' => fake()->dateTimeBetween('-1 year', '-1 week')->format('Y-m-d'),
        ]);
    }
}

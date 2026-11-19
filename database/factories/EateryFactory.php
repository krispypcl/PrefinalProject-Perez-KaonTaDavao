<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eatery>
 */
class EateryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Build a local-sounding name like "Kan-anan ni Santos".
        // unique() on the last name makes sure no two factory eateries share a name.
        $prefixes = ['Kan-anan ni', 'Sinugbahan ni', 'Lutong Bahay ni', 'Kainan ni', 'Pungko-Pungko ni'];
        $name = fake()->randomElement($prefixes) . ' ' . fake()->unique()->lastName();

        $specialties = [
            'Kinilaw na Tuna', 'Sinugbang Panga', 'Pochero', 'Sinigang na Baboy',
            'Adobong Manok', 'Lechon Manok', 'Durian Shake', 'Bulalo', 'Humba', 'Utan Bisaya',
        ];

        return [
            // pick a random district that is already seeded
            'district_id' => District::inRandomOrder()->value('id'),
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->randomElement($specialties),
            'is_open' => true,
        ];
    }

    /**
     * closed() state: same eatery but is_open is false.
     * Usage: Eatery::factory()->closed()->create();
     */
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_open' => false,
        ]);
    }
}

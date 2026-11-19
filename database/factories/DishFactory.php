<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    /**
     * Define the model's default state.
     * eatery_id comes from the relationship: $eatery->dishes()->saveMany(...)
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dishes = [
            'Tinolang Isda', 'Kinilaw na Tanigue', 'Sinugbang Baboy', 'Pancit Bisaya', 'Lumpia',
            'Adobong Pusit', 'Ginataang Kalabasa', 'Pinakbet', 'Fried Chicken', 'Halo-Halo',
            'Mango Shake', 'Puso Rice', 'Tuna Panga', 'Chicken Inasal', 'Bam-i',
        ];

        return [
            'name' => fake()->randomElement($dishes),
            'price' => fake()->numberBetween(8, 50) * 5, // 40.00 to 250.00, steps of 5 pesos
            'is_bestseller' => fake()->boolean(25),      // around 1 in 4 dishes is a bestseller
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===== 1. 3 reviews for my own eatery =====
        $myEatery = Eatery::where('slug', 'carinderia-ni-perez')->first();
        $chris = User::where('email', 'perez@kaonta.test')->first();
        $tita = User::where('email', 'tita.perez@kaonta.test')->first();

        // The factory fills in anything we don't pass (like a random user for
        // the 3rd review). saveMany() through the relationship sets eatery_id.
        // Different created_at dates so "newest first" is easy to see.
        $myEatery->reviews()->saveMany([
            Review::factory()->make([
                'user_id' => $tita->id,
                'rating' => 5,
                'body' => 'Lami kaayo! Balik-balikan ni Tita Perez.',
                'created_at' => now(),
            ]),
            Review::factory()->make([
                'user_id' => $chris->id,
                'rating' => 4,
                'body' => 'Sabaw sa tinola init kaayo, perfect for rainy days.',
                'created_at' => now()->subDays(3),
            ]),
            Review::factory()->make([
                'rating' => 5,
                'body' => 'Cheap and filling meal, the durian shake is a must try.',
                'created_at' => now()->subDays(10),
            ]),
        ]);

        // ===== 2. 0 to 6 random reviews for every OPEN factory eatery =====
        // Closed eateries get no reviews, so we only take is_open = true.
        $openEateries = Eatery::where('is_open', true)
            ->where('id', '!=', $myEatery->id)
            ->get();

        foreach ($openEateries as $eatery) {
            $eatery->reviews()->saveMany(Review::factory()->count(rand(0, 6))->make());
        }
    }
}

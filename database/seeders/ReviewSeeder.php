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
        // ===== 1. Reviews for my own eatery (at least 3) =====
        $myEatery = Eatery::where('slug', 'carinderia-ni-perez')->first();
        $chris = User::where('email', 'perez@kaonta.test')->first();
        $tita = User::where('email', 'tita.perez@kaonta.test')->first();
        $someoneElse = User::whereNotIn('id', [$chris->id, $tita->id])->inRandomOrder()->first();

        // created through the eatery's reviews() relationship
        $myEatery->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Perez.',
        ]);

        // created_at is not in $fillable, so for these two older reviews
        // we set the date first and then save() them through the relationship
        $review = new Review([
            'user_id' => $chris->id,
            'rating' => 4,
            'body' => 'Sabaw sa tinola init kaayo, perfect for rainy days.',
        ]);
        $review->created_at = now()->subDays(3);
        $myEatery->reviews()->save($review);

        $review = new Review([
            'user_id' => $someoneElse->id,
            'rating' => 5,
            'body' => 'Cheap and filling meal, the durian shake is a must try.',
        ]);
        $review->created_at = now()->subDays(10);
        $myEatery->reviews()->save($review);

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

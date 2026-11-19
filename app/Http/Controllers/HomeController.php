<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Single action controller: Laravel calls __invoke() automatically.
     */
    public function __invoke()
    {
        // the three counts on the home page
        $eateryCount = Eatery::count();
        $districtCount = District::count();
        $reviewCount = Review::count();

        // Top Rated: the 3 eateries with the highest average rating.
        // has('reviews') skips eateries with no reviews yet.
        // with() eager-loads district and features so the cards don't cause N+1,
        // withAvg/withCount add reviews_avg_rating and reviews_count in the same query.
        $topRated = Eatery::with(['district', 'features'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->has('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->take(3)
            ->get();

        return view('home', compact('eateryCount', 'districtCount', 'reviewCount', 'topRated'));
    }
}

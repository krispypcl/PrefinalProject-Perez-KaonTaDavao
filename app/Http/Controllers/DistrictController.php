<?php

namespace App\Http\Controllers;

use App\Models\District;

class DistrictController extends Controller
{
    /**
     * List of all districts with how many eateries each one has.
     */
    public function index()
    {
        // withCount adds an eateries_count column, no need to load every eatery
        $districts = District::withCount('eateries')->orderBy('name')->get();

        return view('districts.index', compact('districts'));
    }

    /**
     * One district with its eateries as cards.
     */
    public function show(District $district)
    {
        // load the eateries plus everything the eatery card needs
        $district->load(['eateries' => function ($query) {
            $query->with(['district', 'features'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->orderBy('name');
        }]);

        // counts the reviews through the hasManyThrough relationship
        // (District -> Eatery -> Review), saved as $district->reviews_count
        $district->loadCount('reviews');

        return view('districts.show', compact('district'));
    }
}

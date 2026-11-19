<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;

class EateryController extends Controller
{
    /**
     * Eatery list with filters (?q=, ?district=, ?feature=) and pagination.
     */
    public function index(Request $request)
    {
        // start the query and eager-load what the eatery card needs
        $query = Eatery::with(['district', 'features'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        // ?q= searches the name OR the specialty.
        // The two conditions are grouped inside where(function...) so the
        // OR does not break the other filters: (name LIKE q OR specialty LIKE q) AND ...
        if ($request->filled('q')) {
            $search = $request->input('q');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('specialty', 'like', '%' . $search . '%');
            });
        }

        // ?district= is a district id from the select
        if ($request->filled('district')) {
            $query->where('district_id', $request->input('district'));
        }

        // ?feature= is a feature name; whereHas checks the pivot table
        if ($request->filled('feature')) {
            $feature = $request->input('feature');

            $query->whereHas('features', function ($q) use ($feature) {
                $q->where('name', $feature);
            });
        }

        // A-Z, 6 per page. withQueryString() keeps ?q=&district=&feature=
        // in the pagination links so page 2 still uses the same filters.
        $eateries = $query->orderBy('name')->paginate(6)->withQueryString();

        // for the filter selects
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact('eateries', 'districts', 'features'));
    }

    /**
     * One eatery page. $eatery is found by slug (route model binding).
     */
    public function show(Eatery $eatery)
    {
        // load() = eager loading on a model we already have
        $eatery->load([
            'district',
            'features',
            'permit',
            'dishes',
            'reviews' => function ($query) {
                $query->with('user')->latest(); // newest review first + reviewer name
            },
        ]);
        $eatery->loadAvg('reviews', 'rating');
        $eatery->loadCount('reviews');

        // users for the Reviewer select in the review form, A-Z
        $users = User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }
}

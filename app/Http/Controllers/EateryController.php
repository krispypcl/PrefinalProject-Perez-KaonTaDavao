<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        // users for the Reviewer select in the review form, A-Z
        $users = User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }

    /**
     * Show the "Add Eatery" form.
     */
    public function create()
    {
        // an empty eatery so the shared _form can use $eatery on both create and edit
        // (is_open is true so the "Open" box starts checked)
        $eatery = new Eatery(['is_open' => true]);

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('eatery', 'districts', 'features'));
    }

    /**
     * Save a new eatery.
     * StoreEateryRequest validates first; if it fails, Laravel goes back
     * to the form with the errors and old input automatically.
     */
    public function store(StoreEateryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        // 1. create the eatery. $fillable only lets the eatery columns through,
        //    so features, permit_no and expires_on are skipped here.
        //    (is_open is always sent: 0 from the hidden input or 1 from the checkbox)
        $eatery = Eatery::create($data);

        // 2. create the permit through the hasOne relationship (fills eatery_id)
        $eatery->permit()->create([
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);

        // 3. sync() writes the pivot rows for the checked features
        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('success', 'Eatery added.');
    }

    /**
     * Show the edit form, pre-filled with the eatery, its permit and features.
     */
    public function edit(Eatery $eatery)
    {
        $eatery->load(['permit', 'features']);

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    /**
     * Save changes to an eatery, its permit and its features.
     */
    public function update(UpdateEateryRequest $request, Eatery $eatery)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']); // the slug follows the new name

        $eatery->update($data);

        // update the permit through the hasOne relationship
        $eatery->permit()->update([
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);

        // sync() removes unchecked features and adds new ones in the pivot
        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('success', 'Eatery updated.');
    }

    /**
     * Delete an eatery and everything that belongs to it.
     * The children are deleted first through the relationships,
     * otherwise the foreign keys would stop us from deleting the eatery.
     */
    public function destroy(Eatery $eatery)
    {
        $eatery->permit()->delete();     // hasOne
        $eatery->dishes()->delete();     // hasMany
        $eatery->reviews()->delete();    // hasMany
        $eatery->features()->detach();   // removes the eatery_feature pivot rows
        $eatery->delete();

        return redirect()->route('eateries.index')->with('success', 'Eatery deleted.');
    }
}

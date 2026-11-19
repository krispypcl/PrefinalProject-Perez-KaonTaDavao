<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Eatery;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Post a review for an eatery.
     * StoreReviewRequest already returned 403 if the eatery is closed,
     * and validated user_id, rating and body.
     */
    public function store(StoreReviewRequest $request, Eatery $eatery)
    {
        // created through the eatery's reviews() relationship, so eatery_id is filled in
        $eatery->reviews()->create($request->validated());

        return redirect()->route('eateries.show', $eatery)->with('success', 'Salamat! Review posted.');
    }

    /**
     * Delete a review and go back to its eatery page.
     */
    public function destroy(Review $review)
    {
        // get the eatery first, before the review is deleted
        $eatery = $review->eatery;

        $review->delete();

        return redirect()->route('eateries.show', $eatery)->with('success', 'Review deleted.');
    }
}

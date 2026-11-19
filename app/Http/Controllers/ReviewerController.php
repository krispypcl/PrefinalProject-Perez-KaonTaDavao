<?php

namespace App\Http\Controllers;

use App\Models\User;

class ReviewerController extends Controller
{
    /**
     * A reviewer's page: all reviews written by this user, newest first.
     */
    public function show(User $user)
    {
        // load the user's reviews (newest first) and each review's eatery
        // so the eatery name in the loop is not a new query every time
        $user->load(['reviews' => function ($query) {
            $query->with('eatery')->latest();
        }]);

        return view('reviewers.show', compact('user'));
    }
}

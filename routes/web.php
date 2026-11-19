<?php

use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EateryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewerController;
use Illuminate\Support\Facades\Route;

// Home page - single action controller, so we only pass the class (it uses __invoke)
Route::get('/', HomeController::class)->name('home');

// All 7 resource routes: eateries.index, create, store, show, edit, update, destroy
// The {eatery} parameter is found by slug (see getRouteKeyName() in the Eatery model)
Route::resource('eateries', EateryController::class);

// Reviews
Route::post('/eateries/{eatery}/reviews', [ReviewController::class, 'store'])->name('eateries.reviews.store');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Districts
Route::get('/districts', [DistrictController::class, 'index'])->name('districts.index');
Route::get('/districts/{district}', [DistrictController::class, 'show'])->name('districts.show');

// Reviewer page ({user} is found by id)
Route::get('/reviewers/{user}', [ReviewerController::class, 'show'])->name('reviewers.show');

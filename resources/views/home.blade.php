@extends('layouts.app')

@section('content')
    <h1 class="font-display mb-2 text-4xl font-bold">Kaon ta! Let's eat, Davao.</h1>
    <p class="muted mb-6">A guide to carinderias and eateries around Davao City.</p>

    {{-- the three counts --}}
    <div class="mb-10 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="card card-hover p-5 text-center">
            <p class="font-display text-4xl font-bold text-orange-700 dark:text-orange-400">{{ $eateryCount }}</p>
            <p class="muted">Eateries</p>
        </div>
        <div class="card card-hover p-5 text-center">
            <p class="font-display text-4xl font-bold text-orange-700 dark:text-orange-400">{{ $districtCount }}</p>
            <p class="muted">Districts</p>
        </div>
        <div class="card card-hover p-5 text-center">
            <p class="font-display text-4xl font-bold text-orange-700 dark:text-orange-400">{{ $reviewCount }}</p>
            <p class="muted">Reviews</p>
        </div>
    </div>

    <h2 class="font-display mb-4 text-2xl font-bold">Top Rated</h2>

    @if ($topRated->isEmpty())
        <p class="muted">No reviews yet.</p>
    @else
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($topRated as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection

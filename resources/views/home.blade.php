@extends('layouts.app')

@section('content')
    <h1 class="font-display mb-2 text-4xl font-bold">Let's eat, Davao.</h1>
    <p class="text-muted mb-6">A guide to carinderias and eateries around Davao City.</p>

    {{-- the three counts --}}
    <div class="mb-10 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="card card-hover p-5 text-center">
            <p class="font-display text-4xl font-bold text-accent">{{ $eateryCount }}</p>
            <p class="text-muted">Eateries</p>
        </div>
        <div class="card card-hover p-5 text-center">
            <p class="font-display text-4xl font-bold text-accent">{{ $districtCount }}</p>
            <p class="text-muted">Districts</p>
        </div>
        <div class="card card-hover p-5 text-center">
            <p class="font-display text-4xl font-bold text-accent">{{ $reviewCount }}</p>
            <p class="text-muted">Reviews</p>
        </div>
    </div>

    <h2 class="font-display mb-4 text-2xl font-bold">Top Rated</h2>

    @if ($topRated->isEmpty())
        <p class="text-muted">No reviews yet.</p>
    @else
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($topRated as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection

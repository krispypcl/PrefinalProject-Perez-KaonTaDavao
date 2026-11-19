@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-2">Kaon ta! Let's eat, Davao.</h1>
    <p class="text-gray-600 mb-6">A guide to carinderias and eateries around Davao City.</p>

    {{-- the three counts --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
        <div class="bg-white rounded-lg shadow p-5 text-center">
            <p class="text-3xl font-bold text-orange-700">{{ $eateryCount }}</p>
            <p class="text-gray-600">Eateries</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5 text-center">
            <p class="text-3xl font-bold text-orange-700">{{ $districtCount }}</p>
            <p class="text-gray-600">Districts</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5 text-center">
            <p class="text-3xl font-bold text-orange-700">{{ $reviewCount }}</p>
            <p class="text-gray-600">Reviews</p>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4">Top Rated</h2>

    @if ($topRated->isEmpty())
        <p class="text-gray-500">No reviews yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($topRated as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection

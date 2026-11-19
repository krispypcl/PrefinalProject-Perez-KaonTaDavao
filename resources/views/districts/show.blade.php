@extends('layouts.app')

@section('content')
    <a href="{{ route('districts.index') }}" class="text-sm text-orange-700 hover:underline">&larr; All districts</a>

    <h1 class="text-3xl font-bold mt-2">{{ $district->name }}</h1>

    {{-- reviews_count comes from loadCount('reviews') on the hasManyThrough relationship --}}
    <p class="text-gray-600 mb-6">
        {{ $district->reviews_count }} {{ Str::plural('review', $district->reviews_count) }} in {{ $district->name }}
    </p>

    @if ($district->eateries->isEmpty())
        <p class="text-gray-500">No eateries in this district yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($district->eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection

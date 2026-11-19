@extends('layouts.app')

@section('content')
    <a href="{{ route('districts.index') }}" class="link text-sm">&larr; All districts</a>

    <h1 class="font-display mt-2 text-4xl font-bold">{{ $district->name }}</h1>

    {{-- reviews_count comes from loadCount('reviews') on the hasManyThrough relationship --}}
    <p class="text-muted mb-6">
        {{ $district->reviews_count }} {{ Str::plural('review', $district->reviews_count) }} in {{ $district->name }}
    </p>

    @if ($district->eateries->isEmpty())
        <p class="text-muted">No eateries in this district yet.</p>
    @else
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($district->eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection

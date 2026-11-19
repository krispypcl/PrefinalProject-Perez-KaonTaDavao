@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
    <p class="text-gray-600 mb-6">
        {{ $user->reviews->count() }} {{ Str::plural('review', $user->reviews->count()) }} written
    </p>

    <div class="flex flex-col gap-4">
        {{-- reviews and their eatery were eager-loaded in ReviewerController --}}
        @forelse ($user->reviews as $review)
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <a href="{{ route('eateries.show', $review->eatery) }}" class="font-semibold text-orange-800 hover:underline">
                        {{ $review->eatery->name }}
                    </a>
                    <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                </div>
                <x-rating :value="$review->rating" /> <span class="text-sm">{{ $review->rating }}/5</span>
                <p class="mt-1">{{ $review->body }}</p>
            </div>
        @empty
            <p class="text-gray-500">This user has not written any reviews yet.</p>
        @endforelse
    </div>
@endsection

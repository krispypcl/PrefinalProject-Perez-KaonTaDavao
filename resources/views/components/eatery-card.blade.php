{{-- Usage: <x-eatery-card :eatery="$eatery" />
     The controller must load district, features, reviews_avg_rating and reviews_count
     (with(), withAvg(), withCount()) so this card does not run extra queries. --}}
@props(['eatery'])

<div class="bg-white rounded-lg shadow p-5 flex flex-col gap-2">
    <div class="flex items-start justify-between gap-2">
        <a href="{{ route('eateries.show', $eatery) }}" class="text-lg font-semibold text-orange-800 hover:underline">
            {{ $eatery->name }}
        </a>

        @if (! $eatery->is_open)
            <span class="shrink-0 rounded bg-gray-700 px-2 py-0.5 text-xs font-semibold text-white">Closed</span>
        @endif
    </div>

    <div class="text-sm text-gray-600">
        <a href="{{ route('districts.show', $eatery->district) }}" class="hover:underline">{{ $eatery->district->name }}</a>
        &middot; <span class="font-semibold text-green-700">{{ $eatery->priceSigns() }}</span>
    </div>

    @if ($eatery->specialty)
        <p class="text-sm">Specialty: {{ $eatery->specialty }}</p>
    @endif

    {{-- each feature badge links to the list filtered by that feature --}}
    <div class="flex flex-wrap gap-1">
        @foreach ($eatery->features as $feature)
            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
               class="rounded-full bg-orange-100 px-2 py-0.5 text-xs text-orange-800 hover:bg-orange-200">
                {{ $feature->name }}
            </a>
        @endforeach
    </div>

    <div class="mt-auto pt-2 text-sm">
        @if ($eatery->reviews_count > 0)
            <x-rating :value="$eatery->reviews_avg_rating" />
            <span>{{ number_format($eatery->reviews_avg_rating, 1) }} ★ ({{ $eatery->reviews_count }} {{ $eatery->reviews_count == 1 ? 'review' : 'reviews' }})</span>
        @else
            <span class="text-gray-500">No reviews yet</span>
        @endif
    </div>
</div>
